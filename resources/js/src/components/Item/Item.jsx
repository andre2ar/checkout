import classes from './Item.module.css';
import {useCart} from "../../hooks/cart";

const Item = ({name, price, vat, item_total, picture_url, quantity}) => {
    const {moneyFormat} = useCart();

    return (
        <div className={classes.Item}>
            <picture className={classes.Image}>
                <img src={picture_url}/>
            </picture>
            <div className={classes.Details}>
                <h2>{name}</h2>
                <h3>Unit Prices: </h3>
                <h3>Net: €{moneyFormat(price)} | Vat: €{moneyFormat(vat)} | Gross: €{moneyFormat(item_total)}</h3>
                <h3>Quantity: x{quantity}</h3>

                <h3>Subtotal: €{moneyFormat(quantity * item_total)}</h3>
            </div>
        </div>
    )
}

export default Item;
