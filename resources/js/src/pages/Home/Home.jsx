import {Grid} from "../../components/layout/Grid/Grid";
import {useEffect, useState} from "react";
import {api} from "../../services/api";
import {Product} from "../../components/Product/Product";

const Home = () => {
    const [products, setProducts] = useState([]);
    const [loading, setLoading] = useState(true);
    const [content, setContent] = useState('Loading...');

    useEffect(() => {
        setLoading(true)
        api.get('/v1/products')
            .then(response => {
                setProducts(response.data.data);
                setLoading(false);
            });
    }, []);

    useEffect(() => {
        if(loading){
            setContent('Loading...');
            return;
        }

        const newContent = products.map((product) => (
            <Product
                key={product.id}
                id={product.id}
                name={product.name}
                picture_url={product.picture_url}
                price={product.item_total}
            />
        ));

        if(products.length === 0) {
            setContent("No products");
            return;
        }

        setContent(newContent);
    }, [loading, products])

    return (
        <>
            <h1>Products</h1>

            <Grid>
                {content}
            </Grid>
        </>
    );
}

export default Home;
