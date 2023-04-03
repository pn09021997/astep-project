import React, { useState, useEffect } from "react";
import { Link } from "react-router-dom";
import { Col, Row } from "reactstrap";
import "../../../css/TrendingCategories.css";
export default function TrendingCategories() {
    const [productList, setProductList] = useState([]);
    const [categoriesList, setCategoriesList] = useState([]);

    useEffect(() => {
        const fetchData = async () => {
            const result = await axios(
                "http://localhost:8000/api/home-page-lastest-product/"
            );
            setProductList(result.data.products);
            setCategoriesList(result.data.categories);
        };
        fetchData();
    }, []);

    const findCategory = (arr, query) => {
        let result = arr.find((el) => {
            return el.id === query.category_id;
        });
        return result ? result.name : null;
    };

    const trendingCategory = productList.map((product) => {
        return (
            <Col key={product.id}>
                <div className="trending-categories-info">
                    <div className="categories-img--zoom">
                        <img
                            className="trending-category-product-img img-fluid"
                            src={product.product_image}
                            alt={product.product_name}
                        />
                    </div>
                    <div className="info-detail">
                        <Link
                            to={"/categories/" + product.category_id}
                            className="trending-category-title"
                        >
                            # {findCategory(categoriesList, product)}
                        </Link>
                        <br/>
                        <Link
                            to={`/product-detail/${product.id}/reload`}
                            className="trending-category-product-title"
                        >
                            {product.product_name}
                        </Link>
                    </div>
                </div>
            </Col>
        );
    });
    return (
        <div className="trending-categories container-fluid">
            <div className="trending-categories-introduce mb-5">
                <h1>Trending Categories</h1>
            </div>
            <Row xs="1" sm="1" md="3">
                {trendingCategory}
            </Row>
        </div>
    );
}
