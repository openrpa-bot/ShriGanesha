Direct Checkout by URL
Install the module in the normal way.
You can edit the settings for the module on
/admin/commerce/config/orders/direct-checkout-by-url

Allow unknown SKUs in URL
Make it possible to access URLs that have unknown SKUs in them. This could be
useful if you risk ending up with users trying to access old links with
products that does not exist anymore. In which case they would end up with a
cart missing that product.

Reset cart
Reset the cart if the user accesses a URL when they already have something in
their cart. This way you are sure they go directly to checkout with the
products specified, but at the same time, you risk that they lose items they
want from their cart.

Other types of usage for direct checkout include.

Views.
You can build a custom commerce add to cart button using the global custom text
field and adding the following code:
<a href="/direct-checkout-by-url/products={{ sku }}" class="btn btn-default">
Add to cart</a>
