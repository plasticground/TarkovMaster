<?php


namespace App\Models;


use App\Services\ErrorService;

class Validator
{
    private const VALIDATION_FAILED_KEY = 'failed';

    /** @var array  */
    public array $rules = [];

    /** @var array  */
    public array $query = [];

    /** @var array  */
    public array $info = [];

    /** @var array  */
    public array $failed = [];

    /** @var array  */
    public array $errors = [];

    /**
     * Validator constructor.
     * @param array $query
     * @param array $rules
     */
    public function __construct(array $query, array $rules)
    {
        $this->rules = $rules;
        $this->query = $query;

        $this->validate();
    }

    public function validate()
    {
        foreach ($this->rules as $inputName => $rules) {
            if (!isset($this->query[$inputName])) {
                $this->query[$inputName] = null;
            }

            $this->info[$inputName] = [];
            $errors = 0;

            foreach ($rules as $ruleName => $ruleArg) {
                try {
                    $validation = $this->{$ruleName}($inputName, $this->query[$inputName], $ruleArg);

                    if (!$validation) {
                        ++$errors;
                        $this->errors[$inputName][count($this->errors[$inputName])] = $ruleName;
                    }
                } catch (\Throwable $exception) {
                    ErrorService::log($exception->getMessage());
                }
            }

            if ($errors) {
                $this->info[$inputName] += [self::VALIDATION_FAILED_KEY => true];
                array_push($this->failed, $inputName);
            }
        }
    }

    /**
     * @param string $input
     * @param $data
     * @param bool $ruleArgs
     * @return bool
     */
    private function required(string $input, $data, bool $ruleArgs) : bool
    {
        if ($ruleArgs) {
            $condition = !empty($data);
            $this->toInfo($input, __FUNCTION__, $condition);

            return $condition;
        }

        return true;
    }

    /**
     * @param string $input
     * @param $data
     * @param $ruleArgs
     * @return bool
     */
    private function min(string $input, $data, $ruleArgs) : bool
    {
        if (is_array($data)) {
            $condition = count($data) >= $ruleArgs;
            $this->toInfo($input, __FUNCTION__, $condition);

            return $condition;
        } elseif (is_string($data)) {
            $condition = strlen($data) >= $ruleArgs;
            $this->toInfo($input, __FUNCTION__, $condition);

            return $condition;

        } elseif (is_numeric($data)) {
            $condition = $data >= $ruleArgs;
            $this->toInfo($input, __FUNCTION__, $condition);

            return $condition;
        }

        return false;
    }

    /**
     * @param string $input
     * @param $data
     * @param $ruleArgs
     * @return bool
     */
    private function max(string $input, $data, $ruleArgs) : bool
    {
        if (is_array($data)) {
            $condition = count($data) <= $ruleArgs;
            $this->toInfo($input, __FUNCTION__, $condition);

            return $condition;
        } elseif (is_string($data)) {
            $condition = strlen($data) <= $ruleArgs;
            $this->toInfo($input, __FUNCTION__, $condition);

            return $condition;

        } elseif (is_numeric($data)) {
            $condition = $data <= $ruleArgs;
            $this->toInfo($input, __FUNCTION__, $condition);

            return $condition;
        }

        return false;
    }

    /**
     * @param string $input
     * @param $data
     * @param $ruleArgs
     * @return bool
     */
    private function type(string $input, $data, $ruleArgs) : bool
    {
        switch ($ruleArgs) {
            case 'string':
                $this->toInfo($input, __FUNCTION__, is_string($data));
                return is_string($data);

            case 'numeric':
                $this->toInfo($input, __FUNCTION__, is_numeric($data));
                return is_numeric($data);

            default:
                $this->toInfo($input, __FUNCTION__, false);
                return false;
        }
    }

    /**
     * @param string $input
     * @param string $rule
     * @param bool $state
     */
    private function toInfo(string $input, string $rule, bool $state)
    {
        $this->info[$input] += [$rule => $state];
    }
}