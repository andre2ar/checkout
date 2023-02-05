import {Grid} from "../../components/layout/Grid/Grid";
import {useEffect, useState} from "react";
import {api} from "../../services/api";
import {Product} from "../../components/Product/Product";

const Home = () => {
    const [products, setProducts] = useState([]);

    useEffect(() => {
        api.get('/v1/products')
            .then(response => {
                setProducts(response.data.data);
            })
    }, [])

    return (
        <>
            <h1>Products</h1>

            <Grid>
                {products.length === 0
                    ? "Loading..."
                    : products.map((product) => (
                        <Product
                            key={product.id}
                            id={product.id}
                            name={product.name}
                            picture_url={product.picture_url}
                            price={product.item_total}
                        />
                    ))
                }
            </Grid>
        </>
    );
}

export default Home;
