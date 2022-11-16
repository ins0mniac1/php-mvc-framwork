<?php

namespace App\Core\Validator;

class Validator extends RulesAndMessages
{
    public array $rules = [];

    public array $errors = [];
    public array $validated = [];

    public function setRules($rules)
    {
        $this->rules = $rules;
    }

    public function validate($data): bool
    {
        foreach ($this->rules as $attr => $rules) {
            $value = $data[$attr];

            foreach ($rules as $rule){
                $ruleName = $rule;
                if (!is_string($ruleName)) {
                    $ruleName = $rule[0];
                }

                if ($ruleName === self::RULE_REQUIRED && !$value) {
                    $this->addRuleError($attr, self::RULE_REQUIRED);
                }

                if ($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addRuleError($attr, self::RULE_EMAIL);
                }

                if ($ruleName === self::RULE_MIN && strlen($value) < (int)$rule[1]) {
                    $this->addRuleError($attr, self::RULE_MIN, $rule[1]);
                }

                if ($ruleName === self::RULE_MAX && strlen($value) > (int)$rule[1]) {
                    $this->addRuleError($attr, self::RULE_MAX, $rule[1]);
                }

                if ($ruleName === self::RULE_MATCH) {
                    if ($value !== $data[$rule[1]]) {
                        $this->addRuleError($attr, self::RULE_MATCH, $rule[1]);
                    }
                    unset($data[$attr]);
                }

                if ($ruleName === self::RULE_UNIQUE) {
                    $conditions = explode(',', $rule[1]);
                    $table = $conditions[0];
                    $column = $attr;

                    if (isset($conditions[1])){
                        $column = $conditions[1];
                    }

                    $stmt = db()->prepare("SELECT * from $table WHERE $column = :attr");
                    $stmt->bindValue(":attr", $value);
                    $stmt->execute();

                    $record = $stmt->fetchObject();
                    if ($record) {
                        $this->addRuleError($attr, self::RULE_UNIQUE, $column);
                    }
                }
            }
        }

        $this->validated = $data;

        return empty($this->errors);
    }

    public function addError(string $attr, string $msg)
    {
        $this->errors[$attr][] = $msg;
    }

    private function addRuleError(string $attr, string $rule, $param = null)
    {
        $msg = $this->errorMessages()[$rule] ?? '';

        if (! is_null($param)) {
            $toBeReplaced = '{' . $rule . '}';
            $msg = str_replace($toBeReplaced, $param, $msg);
        }

        $this->errors[$attr][] = $msg;
    }
}
