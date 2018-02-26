<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace xutl\pusher;

use Throwable;

class NoChannelAvailableException extends \Exception
{
    /**
     * @var array
     */
    public $results = [];

    /**
     * NoGatewayAvailableException constructor.
     *
     * @param array $results
     * @param int $code
     * @param \Throwable|null $previous
     */
    public function __construct(array $results = [], $code = 0, Throwable $previous = null)
    {
        $this->results = $results;
        parent::__construct('All the channels have failed.', $code, $previous);
    }
}