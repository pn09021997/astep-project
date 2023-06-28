import React, { useState, useLayoutEffect } from "react";
import { Col, Row } from "reactstrap";
import { Link } from "react-router-dom";
import "../../../css/RelatedContent.css";
import { Button } from "react-bootstrap";
import axios from "axios";
export default function RelatedContent(props) {
    const [relatedProducts, setRelatedProducts] = useState([]);
    useLayoutEffect(() => {
        const fetchData = async () => {
            const result = await axios(
                `http://localhost:8000/api/product-detail/${props.productId}`
            );
            setRelatedProducts(result.data.relatedProducts);
        };
        fetchData();
    }, []);

    const goTopPage = () => {
        window.scrollTo(0, 0);
    };

    const relatedList = relatedProducts.map((product, index) => {
        return (
            <Col key={index} md="3">
                <div className="product-info">
                    <div className="product-action--action">
                        <img
                            src={product.product_image}
                            className="img-fluid"
                        />
                        <div className="action-cart">
                            <Button className="btn-block btn-animation">
                                + Quickshop
                            </Button>
                        </div>
                    </div>

                    <div className="info-detail">
                        <Link
                            to={`/product-detail/${product.id}/reload`}
                            onClick={goTopPage}
                            className="info-related-name"
                        >
                            {product.product_name}
                        </Link>
                        <p className="info-detail-price pt-2">${product.price}</p>
                    </div>
                </div>
            </Col>
        );
    });
    return (
        <div className="related">
            <p className="related-title">Related Product</p>
            <div className="related-detail">
                {
                    <div className="related-content">
                        <Row>{relatedList}</Row>
                    </div>
                }
            </div>
        </div>
    );
}
