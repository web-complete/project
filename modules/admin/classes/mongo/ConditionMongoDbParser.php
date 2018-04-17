<?php

namespace modules\admin\classes\mongo;

use WebComplete\core\condition\Condition;

class ConditionMongoDbParser
{
    /**
     * @param Condition|null $condition
     *
     * @return array
     */
    public function filter(Condition $condition = null): array
    {
        $result = [];

        if ($condition) {
            $conditions = $condition->getConditions();
            foreach ($conditions as $cond) {
                if (!\is_array($cond)) {
                    continue;
                }

                $cond = \array_values($cond);
                $type = \array_shift($cond);
                switch ($type) {
                    case Condition::EQUALS:
                        $result[$cond[0]] = \is_array($cond[1])
                            ? ['$in' => $cond[1]]
                            : $cond[1];
                        break;
                    case Condition::NOT_EQUALS:
                        $result[$cond[0]] = \is_array($cond[1])
                            ? ['$nin' => $cond[1]]
                            : ['$ne' => $cond[1]];
                        break;
                    case Condition::LESS_THAN:
                        $result[$cond[0]] = ['$lt' => $cond[1]];
                        break;
                    case Condition::GREATER_THAN:
                        $result[$cond[0]] = ['$gt' => $cond[1]];
                        break;
                    case Condition::LESS_OR_EQUALS:
                        $result[$cond[0]] = ['$lte' => $cond[1]];
                        break;
                    case Condition::GREATER_OR_EQUALS:
                        $result[$cond[0]] = ['$gte' => $cond[1]];
                        break;
                    case Condition::BETWEEN:
                        $result[$cond[0]] = ['$gte' => $cond[1], '$lte' => $cond[2]];
                        break;
                    case Condition::LIKE:
                        $result[$cond[0]] = ['$regex' => $cond[1], '$options' => 'i'];
                        break;
                    case Condition::IN:
                        $result[$cond[0]] = ['$in' => $cond[1]];
                        break;
                }
            }
        }

        return $result;
    }

    /**
     * @param Condition|null $condition
     *
     * @return array
     */
    public function options(Condition $condition = null): array
    {
        $result = [];

        if ($condition) {
            if ($limit = $condition->getLimit()) {
                $result['limit'] = $limit;
                if ($offset = $condition->getOffset()) {
                    $result['skip'] = $offset;
                }
            }
            $sorts = [];
            foreach ($condition->getSort() as $field => $sort) {
                $sorts[$field] = $sort === \SORT_ASC ? 1 : -1;
            }
            if ($sorts) {
                $result['sort'] = $sorts;
            }
        }

        return $result;
    }
}
