<?php

namespace Botble\Ecommerce\Cart;

use Botble\Ecommerce\Cart\Contracts\Buyable;
use Botble\Ecommerce\Facades\EcommerceHelper;
use Botble\Ecommerce\Models\ShippingRuleItem;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use InvalidArgumentException;

class CartItem implements Arrayable, Jsonable
{
    public string $rowId;

    /**
     * The ID of the cart item.
     *
     * @var int|string
     */
    public $id;

    /**
     * The quantity for this cart item.
     *
     * @var int|float
     */
    public $qty;

    /**
     * The name of the cart item.
     *
     * @var string
     */
    public $name;

    /**
     * The price without TAX of the cart item.
     *
     * @var float
     */
    public $price;

    /**
     * The additional_id of the cart item.
     *
     * @var int|string
     */
    public $additional_id;

    /**
     * The shipping_rule_id of the cart item.
     *
     * @var int|string
     */
    public $shipping_rule_id;

    /**
     * The shipping_date_id of the cart item.
     *
     * @var string
     */
    public $shipping_date;

    /**
     * The price without TAX of the cart item.
     *
     * @var string
     */
    public $shipping_time;
    public $recipient_name;
    public $recipient_phone;
    public $recipient_address;
    public $message_text;
    public $message_sender;
    /**
     * The options for this cart item.
     *
     * @var array|Collection
     */
    public $options;

    /**
     * The FQN of the associated model.
     *
     * @var string|null
     */
    protected $associatedModel = null;

    /**
     * The tax rate for the cart item.
     *
     * @var int|float
     */
    protected $taxRate = 0;

    /**
     * CartItem constructor.
     *
     * @param int|string $id
     * @param string $name
     * @param float $price
     * @param array $options
     */
    public function __construct($id, $name, $price, $shipping_rule, $shipping_date, $shipping_time, array $options = [])
    {
        if (empty($id)) {
            throw new InvalidArgumentException('Please supply a valid identifier.');
        }

        if (empty($name)) {
            throw new InvalidArgumentException('Please supply a valid name.');
        }

        $price = floatval($price);

        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->shipping_rule_id = $shipping_rule;
        $this->shipping_date = $shipping_date;
        $this->shipping_time = $shipping_time;
        $this->options = new CartItemOptions($options);
        $this->rowId = $this->generateRowId($id, $options);
        $this->created_at = Carbon::now();
        $this->updated_at = Carbon::now();
    }

    /**
     * Returns the formatted price without TAX.
     */
    public function price(): string
    {
        return format_price($this->price);
    }

    /**
     * Returns the formatted price with TAX.
     */
    public function priceTax(): string
    {
        return format_price($this->priceTax);
    }

    /**
     * Returns the formatted subtotal.
     * Subtotal is price for whole CartItem without TAX
     *
     * @return string
     */
    public function subtotal()
    {
        return format_price($this->subtotal);
    }

    /**
     * Returns the formatted total.
     * Total is price for whole CartItem with TAX
     *
     * @return string
     */
    public function total()
    {
        return format_price($this->total);
    }

    /**
     * Returns the formatted tax.
     *
     * @return string
     */
    public function tax()
    {
        return format_price($this->tax);
    }

    /**
     * Returns the formatted tax.
     *
     * @return string
     */
    public function taxTotal()
    {
        return format_price($this->taxTotal);
    }

    /**
     * Set the quantity for this cart item.
     *
     * @param int|float $qty
     */
    public function setQuantity($qty)
    {
        if (empty($qty) || ! is_numeric($qty)) {
            throw new InvalidArgumentException('Please supply a valid quantity.');
        }

        $this->qty = $qty;
    }

    /**
     * Set the AdditionalID for this cart item.
     *
     * @param int|float $id
     */
    public function setAdditionalID($id)
    {
        if (empty($id) || ! is_numeric($id)) {
            throw new InvalidArgumentException('Please supply a valid AdditionalID.');
        }

        $this->additional_id = $id;
    }

    /**
     * Update the cart item from a Buyable.
     *
     * @param Buyable $item
     * @return void
     */
    public function updateFromBuyable(Buyable $item)
    {
        $this->id = $item->getBuyableIdentifier($this->options);
        $this->name = $item->getBuyableDescription($this->options);
        $this->price = $item->getBuyablePrice($this->options);
        $this->additional_id = $item->additional_id;
        $this->recipient_name = $item->recipient_name;
        $this->recipient_phone = $item->recipient_phone;
        $this->recipient_address = $item->recipient_address;
        $this->message_text = $item->message_text;
        $this->message_sender = $item->message_sender;
        $this->priceTax = $this->price + $this->tax;
    }

    /**
     * Update the cart item from an array.
     *
     * @param array $attributes
     * @return void
     */
    public function updateFromArray(array $attributes)
    {
        $this->id = Arr::get($attributes, 'id', $this->id);
        $this->qty = Arr::get($attributes, 'qty', $this->qty);
        $this->name = Arr::get($attributes, 'name', $this->name);
        $this->price = Arr::get($attributes, 'price', $this->price);
        $this->shipping_rule_id = Arr::get($attributes, 'shipping_rule_id', $this->shipping_rule_id);
        $this->shipping_date = Arr::get($attributes, 'shipping_date', $this->shipping_date);
        $this->shipping_time = Arr::get($attributes, 'shipping_time', $this->shipping_time);
        $this->additional_id = Arr::get($attributes, 'additional_id', $this->additional_id);
        $this->recipient_name = Arr::get($attributes, 'recipient_name', $this->recipient_name);
        $this->recipient_phone = Arr::get($attributes, 'recipient_phone', $this->recipient_phone);
        $this->recipient_address = Arr::get($attributes, 'recipient_address', $this->recipient_address);
        $this->message_text = Arr::get($attributes, 'message_text', $this->message_text);
        $this->message_sender = Arr::get($attributes, 'message_sender', $this->message_sender);
        $this->priceTax = $this->price + $this->tax;
        $this->options = new CartItemOptions(Arr::get($attributes, 'options', $this->options));

        $this->rowId = $this->generateRowId($this->id, $this->options->all());
    }

    /**
     * Associate the cart item with the given model.
     *
     * @param mixed $model
     * @return \Botble\Ecommerce\Cart\CartItem
     */
    public function associate($model)
    {
        $this->associatedModel = is_string($model) ? $model : get_class($model);

        return $this;
    }

    /**
     * Set the tax rate.
     *
     * @param int|float $taxRate
     * @return \Botble\Ecommerce\Cart\CartItem
     */
    public function setTaxRate($taxRate)
    {
        $this->taxRate = $taxRate;

        return $this;
    }

    public function getTaxRate(): float
    {
        return $this->taxRate;
    }
    public function getShippingRule(): ShippingRuleItem
    {
        return ShippingRuleItem::find($this->shipping_rule_id);
    }

    /**
     * Get an attribute from the cart item or get the associated model.
     *
     * @param string $attribute
     * @return mixed
     */
    public function __get($attribute)
    {
        if (property_exists($this, $attribute)) {
            return $this->{$attribute};
        }

        if ($attribute === 'priceTax') {
            if (! EcommerceHelper::isTaxEnabled()) {
                return 0;
            }

            return $this->price + $this->tax;
        }

        if ($attribute === 'subtotal') {
            return $this->qty * $this->price;
        }

        if ($attribute === 'total') {
            return $this->qty * ($this->priceTax);
        }

        if ($attribute === 'tax') {
            if (! EcommerceHelper::isTaxEnabled()) {
                return 0;
            }

            return $this->price * ($this->taxRate / 100);
        }

        if ($attribute === 'taxTotal') {
            if (! EcommerceHelper::isTaxEnabled()) {
                return 0;
            }

            return $this->tax * $this->qty;
        }

        if ($attribute === 'model') {
            return (new $this->associatedModel())->find($this->id);
        }

        return null;
    }

    /**
     * Create a new instance from a Buyable.
     *
     * @param Buyable $item
     * @param array $options
     * @return \Botble\Ecommerce\Cart\CartItem
     */
    public static function fromBuyable(Buyable $item, array $options = [])
    {
        return new self(
            $item->getBuyableIdentifier($options),
            $item->getBuyableDescription($options),
            $item->getBuyablePrice($options),
            $options
        );
    }

    /**
     * Create a new instance from the given array.
     *
     * @param array $attributes
     * @return \Botble\Ecommerce\Cart\CartItem
     */
    public static function fromArray(array $attributes)
    {
        $options = Arr::get($attributes, 'options', []);

        return new self($attributes['id'], $attributes['name'], $attributes['price'], $options);
    }

    /**
     * Create a new instance from the given attributes.
     *
     * @param int|string $id
     * @param string $name
     * @param float $price
     * @param array $options
     * @return \Botble\Ecommerce\Cart\CartItem
     */
    public static function fromAttributes($id, $name, $price, $shipping_rule, $shipping_date, $shipping_time, array $options = [])
    {
        return new self($id, $name, $price, $shipping_rule, $shipping_date, $shipping_time, $options);
    }

    /**
     * Generate a unique id for the cart item.
     *
     * @param string $id
     * @param array $options
     * @return string
     */
    protected function generateRowId($id, array $options): string
    {
        ksort($options);

        return md5($id . serialize($options));
    }

    /**
     * Get the instance as an array.
     */
    public function toArray(): array
    {
        return [
            'rowId' => $this->rowId,
            'id' => $this->id,
            'name' => $this->name,
            'qty' => $this->qty,
            'price' => $this->price,
            'shipping_rule_id' => $this->shipping_rule_id,
            'shipping_date' => $this->shipping_date,
            'shipping_time' => $this->shipping_time,
            'options' => $this->options->toArray(),
            'tax' => $this->tax,
            'subtotal' => $this->subtotal,
            'updated_at' => $this->updated_at,
        ];
    }

    /**
     * Convert the object to its JSON representation.
     *
     * @param int $options
     */
    public function toJson($options = 0): string
    {
        return json_encode($this->toArray(), $options);
    }
}
