<?php

namespace AppBundle\DTO\Response;

/**
 * Class ApiResponse
 *
 * @package AppBundle
 */
class ApiResponse
{
    /**
     * @var bool
     */
    protected $success;

    /**
     * @var array
     */
    protected $errors;

    /**
     * @var int
     */
    protected $httpCode;

    /**
     * @var array
     */
    protected $data;


    /**
     * @return bool
     */
    public function getSuccess()
    {
        return $this->success;
    }

    /**
     * @param bool $success
     *
     * @return $this
     */
    public function setSuccess($success)
    {
        $this->success = $success;

        return $this;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param array $errors
     *
     * @return $this
     */
    public function setErrors(array $errors)
    {
        $this->errors = $errors;

        return $this;
    }
    /**
     * @param string $error
     *
     * @return $this
     */
    public function addError($error)
    {
        $this->errors[] = $error;

        return $this;
    }

    /**
     * @return int
     */
    public function getHttpCode()
    {
        return $this->httpCode;
    }

    /**
     * @param int $httpCode
     *
     * @return $this
     */
    public function setHttpCode($httpCode)
    {
        $this->httpCode = $httpCode;

        return $this;
    }

    /**
     * @param array $data
     * @return ApiResponse
     */
    public function setData(array $data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * NOTE: This should be handled differently in realy life scenario
     * For example by using differnt serialiser like JmsSerializer
     *
     * @return array
     */
    public function serialize()
    {
        if (true === $this->getSuccess()) {
            return [
                'success' => true,
                'httpCode' => $this->getHttpCode(),
                'data' => $this->getData()
            ];
        }

        return [
            'success' => false,
            'httpCode' => $this->getHttpCode(),
            'errors' => $this->getErrors()
        ];
    }
}