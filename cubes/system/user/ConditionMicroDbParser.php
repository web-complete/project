<?php

namespace cubes\system\user;

use WebComplete\core\condition\Condition;

class ConditionMicroDbParser
{

    /**
     * @param Condition|null $condition
     * @param int|null $limit
     * @param int|null $offset
     *
     * @return \Closure|null
     */
    public function filter(Condition $condition = null, int &$limit = null, int &$offset = null)
    {
        if ($condition) {
            $limit = $condition->getLimit();
            $offset = $condition->getOffset();
            $conditions = $condition->getConditions();
            return function (array $item) use ($conditions) {
                foreach ($conditions as $cond) {
                    if (!\is_array($cond)) {
                        continue;
                    }

                    $cond = \array_values($cond);
                    $type = \array_shift($cond);
                    switch ($type) {
                        case Condition::EQUALS:
                            /** @noinspection TypeUnsafeComparisonInspection */
                            if ($item[$cond[0]] != $cond[1]) {
                                return false;
                            }
                            break;
                        case Condition::NOT_EQUALS:
                            /** @noinspection TypeUnsafeComparisonInspection */
                            if ($item[$cond[0]] == $cond[1]) {
                                return false;
                            }
                            break;
                        case Condition::LESS_THAN:
                            if ($item[$cond[0]] >= $cond[1]) {
                                return false;
                            }
                            break;
                        case Condition::GREATER_THAN:
                            if ($item[$cond[0]] <= $cond[1]) {
                                return false;
                            }
                            break;
                        case Condition::LESS_OR_EQUALS:
                            if ($item[$cond[0]] > $cond[1]) {
                                return false;
                            }
                            break;
                        case Condition::GREATER_OR_EQUALS:
                            if ($item[$cond[0]] < $cond[1]) {
                                return false;
                            }
                            break;
                        case Condition::BETWEEN:
                            if ($item[$cond[0]] < $cond[1] || $item[$cond[0]] > $cond[2]) {
                                return false;
                            }
                            break;
                        case Condition::LIKE:
                            if (!\mb_strstr($item[$cond[0]], $cond[1])) {
                                return false;
                            }
                            break;
                        case Condition::IN:
                            if (!\in_array($item[$cond[0]], $cond[1], false)) {
                                return false;
                            }
                            break;
                    }
                }

                return true;
            };
        }

        return null;
    }

    /**
     * @param Condition|null $condition
     *
     * @return \Closure|null
     */
    public function sort(Condition $condition = null)
    {
        if ($condition) {
            $sort = $condition->getSort();
            return function (array $item1, array $item2) use ($sort) {
                foreach ($sort as $field => $dir) {
                    $value1 = $item1[$field] ?? null;
                    $value2 = $item2[$field] ?? null;
                    if ($value1 === $value2) {
                        continue;
                    }
                    return ($value1 <=> $value2) * ($dir === \SORT_ASC ? 1 : -1);
                }
                return 0;
            };
        }

        return null;
    }
}
