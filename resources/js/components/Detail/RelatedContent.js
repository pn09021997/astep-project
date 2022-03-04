import React, { useState, useEffect } from "react";
import { Col, Row } from "reactstrap";
import { Link } from "react-router-dom";
import "../../../css/RelatedContent.css";
import { Button, Container } from "react-bootstrap";
import axios from "axios";
export default function RelatedContent() {
    const [relatedProducts, setRelatedProducts] = useState([]);
    useEffect(() => {
      const fetchData = async () => {
          const result = await axios(
            `http://localhost:8000/api/product-detail/${27}`
        );
        setRelatedProducts(result.data.relatedProducts);
      }
      fetchData();
    }, [])
    
    const relatedList = relatedProducts.map((product, index) => {
        return (
            <Col key={index} md="3">
                <div className="product-info">
                    <div className="product-action--action">
                        <img src={product.product_image} className="img-fluid" />
                        <div className="action-cart">
                            <Button className="btn-block btn-animation">
                                Add Cart
                            </Button>
                        </div>
                    </div>

                    <div className="info-detail">
                        <p className="info-detail-name">{product.product_name}</p>
                        <p className="info-detail-price">$ {product.price}</p>
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
                        <Row>
                            {relatedList}
                        </Row>
                    </div>
                }
            </div>
        </div>
    );
}
