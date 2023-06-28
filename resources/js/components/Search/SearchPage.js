import React, { useState } from "react";
import { useParams } from "react-router-dom";
import { Row, Col } from "react-bootstrap";
import "../../../css/SearchPage.css";
import SearchList from "./SearchList";
import Footer from "../Home/Footer";

export default function SearchPage() {
    const { keyword } = useParams();
    const [listCount, setListCount] = useState(0);

    return (
        <div className="search-page">
            <div className="search-page__content">
                <div className="search__header mb-5">
                    <p className="header-link">
                        {" "}
                        <a href={location.origin} className="home-link">
                            Home
                        </a>{" "}
                        / Search: {listCount} results found for "{keyword}"
                    </p>
                </div>
                <div className="search__body container-fluid">
                    <Row>
                        <Col lg="6" md="6">
                            <p className="search-title">Search results</p>
                        </Col>
                        <Col lg="6" md="6">
                            <p className="search--result-nof">{listCount} matches for <span>{keyword}</span></p>
                        </Col>
                    </Row>
                </div>
                <hr className="search--endline mb-5" />
                <SearchList
                    keyword={keyword}
                    setListCount={setListCount}
                />
            </div>

            <Footer />
        </div>
    );
}
