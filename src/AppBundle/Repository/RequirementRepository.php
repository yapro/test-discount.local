<?php

namespace AppBundle\Repository;

use Symfony\Component\HttpFoundation\Request;

class RequirementRepository extends \Doctrine\ORM\EntityRepository
{
    public function getRequirementsByParams(Request $request) : array
    {
        $sql = ['SELECT r.* FROM requirement r'];
        $where = [];
        $params = [];

        $request->get('birth_date');
        $amenities = $this->getSelectedAmenitiesIds($request->get('amenities'));
        if (!empty($amenities)) {// исключим скидки, у которых указаны услуги
            // попробуем найти скидки которые распространяются на выбранную услугу/услуги
            $sql[] = "INNER JOIN requirements_amenities ra ON ra.requirement_id = r.id";
        }
        if (empty($request->get('gender'))) {// исключаем скидки у которых указан пол
            $where[] = 'r.gender = 0';
        }
        if (empty($request->get('phone_number'))) {
            $where[] = 'r.flag_phone_number = 0';// исключаем скидки у которых поле заполнения телефона является обязательным
            $where[] = 'r.phone_number_end IS NULL';// исключаем скидки у которых поле окончания телефона заполнено
        } else {
            // нам нужны только те скидки, у которых поле заполнения телефона является обязательным
        }

        if (!empty($where)) {
            $sql[] = ' WHERE ' . implode(' AND ', $where);
        }
        $stmt = $this->getEntityManager()->getConnection()->prepare(implode(PHP_EOL, $sql));
        foreach ($params as $k => $v) {
            $stmt->bindValue($k, $v);
        }
        $stmt->execute();

        return $stmt->fetchAll();
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
}
