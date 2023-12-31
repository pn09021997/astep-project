import React, { useEffect, useState } from "react";
import { Row, Col, Button } from "react-bootstrap";
import { Link } from "react-router-dom";
import "../../../css/SearchPage.css";

export default function SearchList(props) {
    const [searchResult, setSearchResult] = useState([]);

    useEffect(() => {
        const fetchData = async () => {
            const result = await axios(
                `http://localhost:8000/api/searchProduct/${props.keyword}`
            );
            setSearchResult(result.data.item);
            props.setListCount(result.data.item.length);
        };
        fetchData();
    }, [props.keyword]);

    const searchList = searchResult.map((product) => {
        return (
            <Col key={product.id} className="product-item--layout-transition">
                <div className="product-info">
                    <div>
                        <img
                            src={product.product_image}
                            className="img-fluid"
                        />
                    </div>

                    <div className="info-detail">
                        <Link
                            to={`/product-detail/${product.id}/reload`}
                            className="info-detail-name"
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
        <div className="search-list">
            <Row xs="1" sm="2" md="3">{searchList}</Row>
        </div>
    );
}
