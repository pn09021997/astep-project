import axios from "axios";
import React, { useState, useEffect } from "react";
import {
    Row,
    Col,
    Button
} from "reactstrap";
import { Link } from "react-router-dom";
import { AvField, AvForm } from "availity-reactstrap-validation";
import { FaFacebookF, FaTwitter, FaPinterest } from "react-icons/fa";
import "../../../css/TopContent.css";
export default function TopContent() {
    const [activeTab, setActiveTab] = useState("1");
    const [productInfo, setProductInfo] = useState([]);
    const [categories, setCategories] = useState([]);
    useEffect(() => {
        const fetchData = async () => {
            const result = await axios(
                `${location.origin}/api/product-detail/27`
            );
            setCategories(result.data.category);
            setProductInfo(result.data.product);
        };
        fetchData();
    }, [])
    const handleOnValid = (event, value) => {
        console.log(value);
    };
    const handleOnInvalid = (event, error, value) => {
        console.log(error);
    };
    const handleChangeTab = (tab) => {
        if (activeTab !== tab) {
            setActiveTab(tab);
        }
    };
    return (
        <div className="detail__top-content">
            <div className="detail__header mt-5">
                <p className="header-link">
                    <a href={location.origin} className="home-link">
                        Home
                    </a>{" "}
                    /{" "}
                    <Link to={`/categories/${categories.id}`} className="category-link">
                        {categories.name}
                    </Link>{" "}
                    / {productInfo.product_name}
                </p>
            </div>
            <div className="product container-fluid">
                <Row lg="2" md="1" sm="1">
                    <Col lg="5">
                        <div className="product__single">
                            <div className="product__name my-3">
                                <h1>{productInfo.product_name}</h1>
                            </div>
                            <div className="product__info-detail my-3">
                                <p className="product__price">$ {productInfo.price}</p>
                            </div>
                            <div className="product__cart-select my-3">
                                <AvForm
                                    onValidSubmit={handleOnValid}
                                    onInvalidSubmit={handleOnInvalid}
                                    className="cart-select-form"
                                >
                                    <Row>
                                        <Col lg="3">
                                            <AvField
                                                name="product-quantity"
                                                type="number"
                                                value={1}
                                                id="input-quantity"
                                            ></AvField>
                                        </Col>
                                        <Col lg="4">
                                            <Button
                                                className="cart-select-form--btn"
                                                id="btn-addCart"
                                            >
                                                Add To Cart
                                            </Button>
                                        </Col>
                                        <Col lg="4">
                                            <Button
                                                className="cart-select-form--btn"
                                                id="btn-buyNow"
                                            >
                                                Buy It Now
                                            </Button>
                                        </Col>
                                    </Row>
                                </AvForm>
                                <div className="product__info-warehouse my-3">
                                    <ul>
                                        <li>QUANTITY: {productInfo.quantity}</li>
                                        <li>AVAILABLE: {(productInfo.quantity >= 1) ? "AVAILABLE" : "UNAVAILABLE"}</li>
                                    </ul>
                                </div>
                                <hr />
                                <div className="social-sharing my-3">
                                    <p>Share:</p>{" "}
                                    <button className="social-sharing--btn-link">
                                        <FaFacebookF />
                                    </button>{" "}
                                    <button className="social-sharing--btn-link">
                                        <FaTwitter />
                                    </button>{" "}
                                    <button className="social-sharing--btn-link">
                                        <FaPinterest />
                                    </button>
                                </div>
                            </div>
                        </div>
                    </Col>
                    <Col lg="7">
                        <div className="img-detail">
                            <img
                                className="img-fluid"
                                src={productInfo.product_image}
                                width="100%"
                            />
                        </div>
                    </Col>
                </Row>
            </div>
        </div>
    );
}
