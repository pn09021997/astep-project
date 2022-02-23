import { filter } from "lodash";
import React, { useState, useEffect } from "react";
import { Col, Row, Button } from "reactstrap";
import "../../../css/CategoriesPage.css";

export default function ProductList(props) {
    const [productList, setProductList] = useState([]);
    useEffect(() => {
        const fetchData = async () => {
            const result = await axios(
                "http://localhost:8000/api/categoriesPage/1/" + props.filterOption
            );
            setProductList(result.data.products);
        };
        fetchData();
    }, [props.filterOption]);
    const renderProductList = productList.map((product) => {
        return (
            <Col key={product.id} className="product-item--layout-transition">
                <div className="product-info">
                    <div className="product-action--action">
                        <img
                            src={product.product_image}
                            className="img-fluid"
                        />
                        <div className="action-cart">
                            <Button
                                color="danger"
                                outline
                                className="btn-block"
                            >
                                Add Cart
                            </Button>
                        </div>
                    </div>  

                    <div className="info-detail">
                        <p className="info-detail-name">
                            {product.product_name}
                        </p>
                        <p className="info-detail-price">$ {product.price}</p>
                    </div>
                </div>
            </Col>
        );
    });

    return (
        <div className="product-list">
            <Row xs={props.layoutCol}>{renderProductList}</Row>
        </div>
    );
}
