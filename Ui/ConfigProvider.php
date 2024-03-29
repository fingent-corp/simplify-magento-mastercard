<?php
/**
 * Copyright (c) 2013-2022 Mastercard
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

namespace MasterCard\SimplifyCommerce\Ui;

use Magento\Checkout\Model\ConfigProviderInterface;
use Magento\Framework\UrlInterface;
use Magento\Payment\Gateway\ConfigInterface;
use MasterCard\SimplifyCommerce\Model\Config\Source\FormType;

class ConfigProvider implements ConfigProviderInterface
{
    const CODE = 'simplifycommerce';
    const EMBEDDED_CODE = 'simplifycommerce_embedded';
    const VAULT_PAYMENT_CODE = 'simplifycommerce_vault';
    const VAULT_EMBEDDED_PAYMENT_CODE = 'simplifycommerce_embedded_vault';
    const PAYMENT_FORM_TYPE = 'payment_form_type';

    const JS_COMPONENT = 'js_component_url';
    const PUBLIC_KEY = 'public_key';
    const IS_MODAL = 'is_modal';
    const REDIRECT_URL = 'redirect_url';
    const VAULT_CODE = 'vault_code';
    const BUTTON_COLOR = 'button_color';

    /**
     * @var ConfigInterface
     */
    protected $config;

    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * @var ConfigInterface
     */
    private $embeddedConfig;

    /**
     * ConfigProvider constructor.
     *
     * @param ConfigInterface $config
     * @param UrlInterface $urlBuilder
     * @param ConfigInterface $embeddedConfig
     */
    public function __construct(
        ConfigInterface $config,
        UrlInterface $urlBuilder,
        ConfigInterface $embeddedConfig
    ) {
        $this->config         = $config;
        $this->urlBuilder     = $urlBuilder;
        $this->embeddedConfig = $embeddedConfig;
    }

    /**
     * @return string
     */
    protected function getPlaceOrderUrl()
    {
        return $this->urlBuilder->getUrl('mastercard/simplify/placeOrder', [
            '_secure' => 1,
        ]);
    }

    /**
     * Retrieve assoc array of checkout configuration
     *
     * @return array
     */
    public function getConfig()
    {
        return [
            'payment' => [
                self::CODE          => [
                    self::JS_COMPONENT => $this->config->getValue(self::JS_COMPONENT),
                    self::PUBLIC_KEY   => $this->config->getValue(self::PUBLIC_KEY),
                    self::IS_MODAL     => $this->config->getValue(self::PAYMENT_FORM_TYPE) == FormType::MODAL,
                    self::REDIRECT_URL => $this->getPlaceOrderUrl(),
                    self::VAULT_CODE   => self::VAULT_PAYMENT_CODE,
                ],
                self::EMBEDDED_CODE => [
                    self::JS_COMPONENT => $this->embeddedConfig->getValue(self::JS_COMPONENT),
                    self::PUBLIC_KEY   => $this->embeddedConfig->getValue(self::PUBLIC_KEY),
                    self::IS_MODAL     => $this->embeddedConfig->getValue(self::PAYMENT_FORM_TYPE) == FormType::MODAL,
                    self::REDIRECT_URL => $this->getPlaceOrderUrl(),
                    self::VAULT_CODE   => self::VAULT_EMBEDDED_PAYMENT_CODE,
                    self::BUTTON_COLOR => $this->embeddedConfig->getValue(self::BUTTON_COLOR),
                ],
            ],
        ];
    }
}
