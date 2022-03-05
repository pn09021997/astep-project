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
                        <div className="footer-logo mb-3">
                            <img
                                src="https://cdn.shopify.com/s/files/1/0076/1708/5530/files/logo_white_360x.png?v=1612539402"
                                alt="uneox logo"
                                className="img-fluid navbar--custom-logo"
                            />
                        </div>
                    </Col>
                    <Col xs="12" sm="12" md="4">
                        <div className="footer-introduce mb-3">
                            <p>THU DUC COLLEGE OF TECHNOLOGY.</p>
                        </div>
                    </Col>
                    <Col xs="12" sm="12" md="2">
                        <div className="footer-contact mb-3">
                            <p>
                                <ul className="footer-contact-detail">
                                    {renderCollections}
                                </ul>
                            </p>
                        </div>
                    </Col>
                    <Col xs="12" sm="12" md="3">
                        <div className="footer-contact mb-3">
                            <p>
                                <ul className="footer-contact-detail">
                                    <li>Email: pn092xxxx@gmail.com</li>
                                    <li>Phone: 092xxxxxxx</li>
                                </ul>
                            </p>
                        </div>
                    </Col>
                </Row>
            </div>
        </div>
    );
}
