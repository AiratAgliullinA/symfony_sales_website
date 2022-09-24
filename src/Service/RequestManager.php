<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Request;

/**
 * Request manager
 */
class RequestManager
{
    /**
     * Return list all valid GET parameters
     *
     * @param Request $request
     *
     * @return array
     */
    public function getAllValidGetParameters(Request $request): array
    {
        $getParameters = $request->query->all();

        return $this->getValidList($getParameters);
    }

    /**
     * Check is all GET parameters valid
     *
     * @param Request $request
     *
     * @return boolean
     */
    public function isAllGetParametersValid(Request $request): bool
    {
        $allGetParameters = $request->query->all();

        $allValidGetParameters = $this->getAllValidGetParameters($request);

        return count($allGetParameters) === count($allValidGetParameters);
    }

    /**
     * Return valid list
     *
     * @param array $list
     *
     * @return array
     */
    protected function getValidList(array $list): array
    {
        return array_filter($list, function($value) {
            return trim($value) !== '';
        });
    }

    /**
     * Unset GET parameter by key
     *
     * @param Request $request
     * @param string $key
     *
     * @return Request
     */
    public function unsetGetParameter(Request $request, string $key): Request
    {
        if ($request->query->get($key)) {
            $request->query->set($key, '');
        }

        return $request;
    }
}