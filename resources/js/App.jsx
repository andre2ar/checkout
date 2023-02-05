import './App.css';
import React, {useEffect} from "react";
import {Route, Routes} from "react-router";
import Home from "./src/pages/Home/Home";
import Cart from "./src/pages/Cart/Cart";
import {Header} from "./src/components/layout/Header/Header";
import {Main} from "./src/components/layout/Main/Main";
import {useCart} from "./src/hooks/cart";

const App = () => {
    const { cart, newCart } = useCart();

    useEffect(() => {
        if(!cart) {
            newCart();
        }
    }, []);

    return (
        <>
            <Header />

            <Main>
                <Routes >
                    <Route path='/' element={<Home />} />
                    <Route path='/cart' element={<Cart />} />
                </Routes>
            </Main>
        </>
    );
}

export default App;
