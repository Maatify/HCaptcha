<?php
/**
 * @PHP       Version >= 8.0
 * @Liberary  HCaptcha
 * @Project   HCaptcha
 * @copyright ©2024 Maatify.dev
 * @see       https://www.maatify.dev Visit Maatify.dev
 * @link      https://github.com/Maatify/HCaptcha View project on GitHub
 * @link      https://docs.hcaptcha.com/ Visit hCaptcha Website
 * @since     2023-08-07 11:00 PM
 * @author    Mohamed Abdulalim (megyptm) <mohamed@maatify.dev>
 * @Maatify   HCaptcha :: HCaptchaPublisherProValidation
 * @note      This Project using for Call HCaptcha Validation
 *
 * This program is distributed in the hope that it will be useful - WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 * FITNESS FOR A PARTICULAR PURPOSE.
 *
 */

namespace Maatify\HCaptcha;

use Maatify\Json\Json;

class HCaptchaPublisherProValidation extends HCaptchaRequestCall
{

    public ?bool $success = null;
    public array $response = [];

    private static ?self $instance = null;
    private string $remote_ip = '';
    private string $site_key = '';

    public static function getInstance(string $secret_key = ''): self
    {
        if (null === self::$instance) {
            self::$instance = new self($secret_key);
        }

        return self::$instance;
    }

    public function setRemoteIp(string $remote_ip): static
    {
        $this->remote_ip = $remote_ip;
        return $this;
    }

    public function setSiteKey(string $site_key): static
    {
        $this->site_key = $site_key;
        return $this;
    }

    private function curlValidation(): bool
    {
        $params = array(
            'secret'   => $this->secret_key,
            'response' => $_POST['h-captcha-response'] ?? '',
        );

        if(!empty($this->remote_ip)){
            $params['remote_ip'] = $this->remote_ip;
        }

        if(!empty($this->site_key)){
            $params['site_key'] = $this->site_key;
        }

        $response_data = $this->curlPost($params);
        $this->response = (array)$response_data;

        $this->success = (isset($response_data->success) && $response_data->success);

        return $this->success;
    }

    private function validate(): bool
    {
        if ($this->success === null) {
            $this->success = $this->curlValidation();
        }

        return $this->success;
    }

    public function jsonErrors(): void
    {
        if (empty($_POST['h-captcha-response'])) {
            Json::Missing('h-captcha-response');
        }
        if (! $this->validate()) {
            Json::Invalid('h-captcha-response', Json::JsonFormat($this->response));
        }
    }

    public function isSuccess(): bool
    {
        return $this->validate();
    }

    public function getResponse(): array
    {
        $this->validate();

        return $this->response;
    }
}