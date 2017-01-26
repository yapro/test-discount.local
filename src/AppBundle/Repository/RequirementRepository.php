<?php
declare(strict_types = 1);

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class RequirementRepository extends EntityRepository
{
    /**
     * @param \DateTime $birthDate
     * @param array $amenities
     * @param string $phoneNumber
     * @param int $gender
     * @return int
     */
    public function getMaxDiscount(
        \DateTime $birthDate,
        array $amenities,
        string $phoneNumber,
        int $gender
    ) : int
    {
        $sql = ['SELECT r.discount FROM requirement r'];
        $where = [];
        $params = [];
        $sql[] = $this->getAmenitiesFilter($amenities);
        $where[] = $this->getBirthDayConditions($birthDate);
        $where[] = $this->getGenderConditions($gender);

        $phone = $this->getPhoneConditions($phoneNumber);
        $where[] = $phone['where'];
        $params['phone'] = $phone['number'];

        $activity = $this->getActivityDatesConditions();
        $where[] = $activity['where'];
        $params['today'] = $activity['today'];

        $sql[] = 'WHERE ' . implode(' AND' . PHP_EOL, $where);
        $sql[] = 'ORDER BY r.discount DESC';
        $stmt = $this->getEntityManager()->getConnection()->prepare(implode(PHP_EOL, $sql));
        foreach ($params as $k => $v) {
            $stmt->bindValue($k, $v);
        }
        $stmt->execute();
        $result = $stmt->fetch();
        $stmt->closeCursor();

        return empty($result['discount']) ? 0 : filter_var($result['discount'], FILTER_VALIDATE_INT);
    }

    /**
     * @param array $amenities
     * @return string
     */
    private function getAmenitiesFilter(array $amenities) : string
    {
        $selectedAmenitiesIds = $this->getSelectedAmenitiesIds($amenities);
        if (count($selectedAmenitiesIds) === 0) {
            return '';// клиента интересуют скидки на любые услуги
        }
        // клиента интересуют только скидки на определенные услуги
        return 'INNER JOIN requirements_amenities ra ON ra.requirement_id = r.id 
            AND ra.amenity_id IN (' . implode(',', $selectedAmenitiesIds) . ')';
    }

    /**
     * @param array $amenities
     * @return array
     */
    private function getSelectedAmenitiesIds(array $amenities) : array
    {
        $result = [];
        foreach ($amenities as $amenity) {
            if (array_key_exists('isSelected', $amenity) && $amenity['isSelected'] === true) {
                $result[] = $amenity['id'];
            }
        }
        return $result;
    }

    /**
     * @param \DateTime $birthDateReal
     * @return string
     */
    private function getBirthDayConditions(\DateTime $birthDateReal) : string
    {
        $birthDate = (new \DateTime(date('Y') . $birthDateReal->format('-m-d')))->setTime(0, 0, 0);
        $today = (new \DateTimeImmutable())->setTime(0, 0, 0);
        $weekBefore = $today->modify('-1 week');
        $weekAfter = $today->modify('1 week');
        $isWeekBefore = $birthDate >= $weekBefore;
        $isWeekAfter = $birthDate <= $weekAfter;
        // если д.р. клиента попадает под условие неделя до и неделея после д.р.
        if ($isWeekBefore && $isWeekAfter) {
            $where = [];
            $where[] = 'r.flag_birth_date_before = 1 AND r.flag_birth_date_after = 1';
            // если дата рождения  клиента попадает под условие - неделя после
            if ($isWeekBefore && $birthDate <= $today) {
                $where[] = 'r.flag_birth_date_before IN (0,1) AND r.flag_birth_date_after = 0';
            }
            // если дата рождения клиента попадает под условие - неделя до
            if ($birthDate > $today && $isWeekAfter) {
                $where[] = 'r.flag_birth_date_before = 0 AND r.flag_birth_date_after IN (0,1)';
            }
            return '(' . implode(' OR ', $where) . ')';
        }
        return 'r.flag_birth_date_before = 0 AND r.flag_birth_date_after = 0';
    }

    /**
     * @param int $gender
     * @return string
     */
    private function getGenderConditions(int $gender) : string
    {
        if ($gender === 1) {
            return 'r.gender IN (0,1)';
        } elseif ($gender === 2) {
            return 'r.gender IN (0,2)';
        } else {
            return 'r.gender = 0';
        }
    }

    /**
     * @param string $phone
     * @return array
     */
    private function getPhoneConditions(string $phone) : array
    {
        $where = [];
        if (!empty($phone)) {// нам нужны как требования без заполнения, так и с четко определнными параметрами
            // нам нужны только те требования, у которых поле заполнения телефона является обязательным
            // и у которых поле окончания телефона заполнено и совпадает с введенными данными
            $where[] = 'r.flag_phone_number = 1 AND r.phone_number_end = :phone';
        }
        // берем требования у которых поле заполнения телефона является не обязательным
        $where[] = 'r.flag_phone_number = 0 AND r.phone_number_end IS NULL';
        return [
            'where' => '(' . implode(' OR ', $where) . ')',
            'number' => substr((string)$phone, -4),
        ];
    }

    /**
     * @return array
     */
    private function getActivityDatesConditions() : array
    {
        return [
            'where' => 'r.date_from <= :today AND (r.date_to >= :today OR r.date_to IS NULL)',
            'today' => date('Y-m-d'),
        ];
    }
}
