<?php
/**
 * Copyright (c) 2013-2020 Mastercard
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace MasterCard\SimplifyCommerce\lib;

use Magento\Framework\ObjectManagerInterface;
use Magento\Payment\Gateway\ConfigInterface;

class SimplifyAdapterFactory
{
    /**
     * @var ObjectManagerInterface
     */
    private $objectManager;

    /**
     * @var ConfigInterface
     */
    private $config;

    /**
     * SimplifyAdapterFactory constructor.
     * @param ObjectManagerInterface $objectManager
     * @param ConfigInterface $config
     */
    public function __construct(
        ObjectManagerInterface $objectManager,
        ConfigInterface $config
    ) {
        $this->objectManager = $objectManager;
        $this->config = $config;
    }

    /**
     * @return SimplifyAdapter
     */
    public function create()
    {
        // phpcs:ignore
        return $this->objectManager->create(SimplifyAdapter::class, [
            'publicKey' => $this->config->getValue('public_key'),
            'privateKey' => $this->config->getValue('private_key'),
        ]);
    }
}
