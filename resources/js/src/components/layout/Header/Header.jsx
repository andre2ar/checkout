import classes from './Header.module.css';
import { ShoppingCart } from "phosphor-react";
import {Button} from "../../Button/Button";
import {useCallback} from "react";
import {Link, useNavigate} from "react-router-dom";
import {useCart} from "../../../hooks/cart";
import Badge from "../../Badge/Badge";

export function Header() {
    let navigate = useNavigate();

    const { cart } = useCart();

    const goToCart = useCallback(() => {
        navigate("cart", { replace: true });
    }, []);

    return (
        <header className={classes.Header}>
            <Link to="/">
                <strong>Aphix Webshop</strong>
            </Link>

            <Button onClick={goToCart}>
                <ShoppingCart size={30}/>
                <Badge>
                    {cart?.products.reduce((accumulator, product) => accumulator + product.pivot.quantity, 0)}
                </Badge>
            </Button>
        </header>
    );
}
