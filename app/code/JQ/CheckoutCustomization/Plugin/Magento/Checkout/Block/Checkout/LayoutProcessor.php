<?php


namespace JQ\CheckoutCustomization\Plugin\Magento\Checkout\Block\Checkout;

use Magento\Customer\Model\AttributeMetadataDataProvider;
use Magento\Ui\Component\Form\AttributeMapper;
use Magento\Checkout\Block\Checkout\AttributeMerger;
use Magento\Checkout\Model\Session as CheckoutSession;

class LayoutProcessor
{
    /**
     * @var AttributeMetadataDataProvider
     */
    public $attributeMetadataDataProvider;

    /**
     * @var AttributeMapper
     */
    public $attributeMapper;

    /**
     * @var AttributeMerger
     */
    public $merger;

    /**
     * @var CheckoutSession
     */
    public $checkoutSession;

    /**
     * @var null
     */
    public $quote = null;

    /**
     * LayoutProcessor constructor.
     *
     * @param AttributeMetadataDataProvider $attributeMetadataDataProvider
     * @param AttributeMapper $attributeMapper
     * @param AttributeMerger $merger
     * @param CheckoutSession $checkoutSession
     */
    public function __construct(
        AttributeMetadataDataProvider $attributeMetadataDataProvider,
        AttributeMapper $attributeMapper,
        AttributeMerger $merger,
        CheckoutSession $checkoutSession
    ) {
        $this->attributeMetadataDataProvider = $attributeMetadataDataProvider;
        $this->attributeMapper = $attributeMapper;
        $this->merger = $merger;
        $this->checkoutSession = $checkoutSession;
    }

    /**
     * @param \Magento\Checkout\Block\Checkout\LayoutProcessor $subject
     * @param array $jsLayout
     * @return array
     */
    public function afterProcess(
        \Magento\Checkout\Block\Checkout\LayoutProcessor $subject, array $jsLayout
    ) {
        /* Shipping form fields */
        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']
        ['children']['shippingAddress']['children']['shipping-address-fieldset']['children']['switch_field'] = $this->getSwitchField();

        $shippingFormFields = &$jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children'];

        if (isset($shippingFormFields['company'])) {
            $shippingFormFields['company']['sortOrder'] = 60;
        }
        if (isset($shippingFormFields['vat_id'])) {
            $shippingFormFields['vat_id']['sortOrder'] = 65;
            //$shippingFormFields['vat_id']['label'] = __('NIP');
        }
        if (isset($shippingFormFields['postcode'])) {
            $shippingFormFields['postcode']['sortOrder'] = 80;
        }
        if (isset($shippingFormFields['city'])) {
            $shippingFormFields['city']['sortOrder'] = 90;
        }
        if (isset($shippingFormFields['region_id'])) {
            $shippingFormFields['region_id']['sortOrder'] = 100;
        }
        if (isset($shippingFormFields['country_id'])) {
            $shippingFormFields['country_id']['sortOrder'] = 110;
        }
        if (isset($shippingFormFields['telephone'])) {
            $shippingFormFields['telephone']['sortOrder'] = 120;
        }


        /* Billing form fields */
        if (isset($jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']
            ['payment']['children']['payments-list']['children']
        )) {
            foreach ($jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']['payment']['children']['payments-list']['children'] as $key => $payment) {

                $billingFormFields = &$jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']
                ['payment']['children']['payments-list']['children'][$key]['children']['form-fields']['children'];

                $billingFormFields['switch_field'] = $this->getSwitchField(); // switch as: Private Person or Company

                if (isset($billingFormFields['company'])) {
                    $billingFormFields['company']['sortOrder'] = 60;
                    $billingFormFields['company']['validation'] = ['validate-private-business' => true];
                }
                if (isset($billingFormFields['vat_id'])) {
                    $billingFormFields['vat_id']['sortOrder'] = 65;
                    $billingFormFields['vat_id']['validation'] = ['validate-private-business' => true];
                    //$billingFormFields['vat_id']['label'] = __('NIP');
                }
                if (isset($billingFormFields['postcode'])) {
                    $billingFormFields['postcode']['sortOrder'] = 80;
                }
                if (isset($billingFormFields['city'])) {
                    $billingFormFields['city']['sortOrder'] = 90;
                }
                if (isset($billingFormFields['region_id'])) {
                    $billingFormFields['region_id']['sortOrder'] = 100;
                }
                if (isset($billingFormFields['country_id'])) {
                    $billingFormFields['country_id']['sortOrder'] = 110;
                }
                if (isset($billingFormFields['telephone'])) {
                    $billingFormFields['telephone']['sortOrder'] = 120;
                }

            }
        }
        return $jsLayout;
    }

    protected function getSwitchField()
    {
        $customAttributeCode = 'private_business';
        $customField = [
            'component' => 'JQ_CheckoutCustomization/js/view/form/element/radio',
            'config' => [
                'customScope' => 'shippingAddress.custom_attributes',
                'customEntry' => null,
                'template' => 'ui/form/field',
                'elementTmpl' => 'JQ_CheckoutCustomization/form/element/radio'
            ],
            'dataScope' => 'custom_attributes' . '.' . $customAttributeCode,
            'label' => __('Order as'),
            'provider' => 'checkoutProvider',
            'sortOrder' => 0,
            'validation' => [
                'required-entry' => false
            ],
            'options' => [],
            'filterBy' => null,
            'customEntry' => null,
            'visible' => true,
        ];

        return $customField;
    }
}