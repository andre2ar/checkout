import {useCart} from "../../hooks/cart";
import Item from "../../components/Item/Item";
import {Button} from "../../components/Button/Button";
import classes from './Cart.module.css';
import {Eraser} from "phosphor-react";

const Cart = () => {
    const { cart, moneyFormat, newCart } = useCart();
    const itemsQuantity = cart?.products.reduce((accumulator, product) => accumulator + product.pivot.quantity, 0);

    return (
        <>
            <div className={classes.Header}>
                <h1>Cart</h1>
                <Button onClick={newCart}>
                    <Eraser size={25}/> Clear cart
                </Button>
            </div>

            {cart.products.map((product) => (
                <Item
                    name={product.name}
                    picture_url={product.picture_url}
                    price={product.price}
                    vat={product.vat}
                    item_total={product.item_total}
                    quantity={product.pivot.quantity}
                />
            ))}

            <h2>Subtotal ({itemsQuantity} items): €${moneyFormat(cart.net_total)}(Net) + €${moneyFormat(cart.vat_total)}(VAT) = €{moneyFormat(cart.gross_total)} </h2>
        </>
    );
}

export default Cart;
