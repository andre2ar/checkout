import {createContext, useContext, useState} from "react";
import {api} from "../services/api";

const CartContext = createContext({});

export const CartProvider = ({children}) => {
    const [cart, setCart] = useState(() => {
        const cart = localStorage.getItem('@Checkout:cart');

        if(cart) {
            return JSON.parse(cart);
        }

        return null;
    });

    const newCart = async () => {
        if(cart) {
            await api.delete(`/v1/cart/${cart.id}`);
        }

        const response = await api.post('/v1/cart');

        localStorage.setItem('@Checkout:cart', JSON.stringify(response.data));

        setCart(response.data);

        return response.data;
    };

    const addToCart = async ({ product_id, quantity }) => {
        let currentCart = cart;
        if(!currentCart) {
            currentCart = await newCart();
        }

        const response = await api.post(`/v1/cart/${currentCart.id}/items`, {
            product_id,
            quantity
        });

        setCart(response.data);

        localStorage.setItem('@Checkout:cart', JSON.stringify(response.data));
    };

    const moneyFormat = (value) => {
        return parseFloat(value).toLocaleString('en-IE', {
            style: 'decimal',
            currency: 'EUR',
            maximumFractionDigits: 2,
            minimumFractionDigits: 2
        });
    }

    return (
        <CartContext.Provider value={{cart, newCart, addToCart, moneyFormat}}>
            { children }
        </CartContext.Provider>
    );
}

export const useCart = () => {
    const context = useContext(CartContext);

    if (!context) {
        throw new Error('useCart must be user within an CartProvider');
    }

    return context;
}
