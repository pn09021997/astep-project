import { React, useState, useEffect } from "react";
import { Col, Row } from "reactstrap";
import { Link } from "react-router-dom";
import "../../../css/Footer.css";

export default function Footer() {
    const [collections, setCollections] = useState([]);
    useEffect(() => {
        const fetchData = async () => {
            const result = await axios(
                `${location.origin}/api/category-is-ramdom`
            );
            setCollections(result.data.categories);
        };
        fetchData();
    }, []);

    const renderCollections = collections.map((collection, index) => {
        return (
            <li key={index}>
                <Link to={`categories/${collection.id}`} className="collections-link"># {collection.name}</Link>
            </li>
        );
    });

    return (
        <div className="footer mt-5">
            <div className="footer-content container-fluid">
                <Row>
                    <Col xs="12" sm="12" md="3">
                        <div className="footer-logo mb-4">
                            <Link
                                to="/"
                            >
                                <img
                                    src="https://shop.mohd.it/media/catalog/category/astep-logo.png"
                                    alt="astep logo"
                                    className="img-fluid navbar--custom-logo"
                                />
                            </Link>
                        </div>
                    </Col>
                    <Col xs="12" sm="12" md="4">
                        <div className="footer-introduce mb-4">
                            <p>2593 Timbercrest Road, Chisana, Alaska Badalas
                                United State,</p>
                        </div>
                    </Col>
                    <Col xs="12" sm="12" md="2">
                        <div className="footer-contact mb-4">
                            <ul className="footer-contact-detail">
                                {renderCollections}
                            </ul>
                        </div>
                    </Col>
                    <Col xs="12" sm="12" md="3">
                        <div className="footer-contact mb-4">
                            <ul className="footer-contact-detail">
                                <li>Email: pn092xxxx@gmail.com</li>
                                <li>Phone: 092xxxxxxx</li>
                            </ul>
                        </div>
                    </Col>
                </Row>
            </div>
        </div>
    );
}
