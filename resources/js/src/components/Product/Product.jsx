import classes from './Product.module.css';
import {Button} from "../Button/Button";
import {Plus} from "phosphor-react";
import {useCart} from "../../hooks/cart";

export function Product({id, name, price, picture_url}) {
    const { addToCart, moneyFormat } = useCart();

    return (
        <div className={classes.Product}>
            <header>
                <h4>{name}</h4>
            </header>
            <img src={picture_url} alt="Product"/>

            <footer>
                <h4>€{moneyFormat(price)}</h4>

                <Button onClick={() => addToCart({product_id: id, quantity: 1})}>
                    <Plus size={25} /> Add to cart
                </Button>
            </footer>
        </div>
    );
}
