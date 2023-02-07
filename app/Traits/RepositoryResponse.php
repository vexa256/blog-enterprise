<?php

namespace App\Traits;

trait RepositoryResponse
{
    /**
     * Ajax response.
     */
    protected $response;

    /**
     * Success Returns
     *
     * @param  array|string $data
     * @return $this
     */
    public function success($data, $message = null)
    {
        $this->response = ['status' => 'success', 'message' => $message, 'data' => $data];
        return $this;
    }

    /**
     * Success Returns
     *
     * @param  array|string $data
     * @return $this
     */
    public function add_extra($extra)
    {
        $this->response = array_merge($this->response, $extra);

        return $this;
    }

    /**
     * Fail Return
     *
     * @param  string $message
     * @return $this
     */
    public function fail($message = null)
    {
        if (!$message) {
            $message = __('Request Failed');
        }
        $this->response = ['status' => 'error', 'message' => $message, 'error' => true, 'data' => null];
        return $this;
    }


    /**
     * Return Response if succeeded
     *
     * @return object
     */
    public function succeeded()
    {
        return $this->response['status'] === 'success';
    }

    /**
     * Return response if failed
     *
     * @return object
     */
    public function failed()
    {
        return $this->response['status'] === 'error';
    }

    /**
     * Return response message
     *
     * @return string
     */
    public function message()
    {
        return $this->response['message'];
    }

    /**
     * Return response data
     *
     * @return mixed
     */
    public function data()
    {
        return $this->response['data'];
    }

    /**
     * Return Response
     *
     * @return array
     */
    public function response()
    {
        return $this->response;
    }

    /**
     * Return Response json
     *
     * @return \Illuminate\Http\Response
     */
    public function json($extra = [])
    {
        return response()->json(array_merge($this->response, $extra));
    }
}
