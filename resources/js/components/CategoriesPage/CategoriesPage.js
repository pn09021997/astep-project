import React, { useState } from "react";
import { FormGroup, Label, Input, Col, Row } from "reactstrap";
import { GoPrimitiveDot } from "react-icons/go";
import { BsFillGridFill, BsFillGrid3X3GapFill } from "react-icons/bs";
import ProductList from "./ProductList";
import "../../../css/CategoriesPage.css";
export default function CategoriesPage() {
    const [filterOption, setFilterOption] = useState("feature");
    const [layoutCol, setLayoutCol] = useState(3);
    const filterProduct = (e) => {
        let filterOption = e.target.value;
        setFilterOption(filterOption);
    };
    const handleConfigLayout = (e) => {
        let layoutNum = e.target.getAttribute("layoutnum");
        setLayoutCol(layoutNum);
    }
    return (
        <div className="categories">
            <div className="categories__header mb-5">
                <h1 className="categories-name">Category Name</h1>
                <p className="header-link">
                    {" "}
                    <a href="*" className="home-link">Home</a> / Category name{" "}
                </p>
            </div>
            <div className="categories__content">
                <Row>
                    <Col className="config" lg="3" md="12">
                        <div className="config-filter">
                            <FormGroup>
                                <Label for="filterProduct" id="filterLabel">
                                    Sort by
                                </Label>
                                <Input
                                    id="filterProduct"
                                    name="select"
                                    type="select"
                                    onChange={filterProduct}
                                >
                                    <option value="feature">Feature</option>
                                    <option value="az">
                                        Alphabetically, A-Z
                                    </option>
                                    <option value="za">
                                        Alphabetically, Z-A
                                    </option>
                                    <option value="price-high-low">
                                        Price, High to Low
                                    </option>
                                    <option value="price-low-high">
                                        Price, Low to High
                                    </option>
                                </Input>
                            </FormGroup>
                        </div>
                        <div className="config-layout">
                            <button onClick={handleConfigLayout} layoutnum="2"><GoPrimitiveDot className="noClick"/></button>
                            <button onClick={handleConfigLayout} layoutnum="3" autoFocus><BsFillGridFill className="noClick"/></button>
                            <button onClick={handleConfigLayout} layoutnum="4"><BsFillGrid3X3GapFill className="noClick"/></button>
                        </div>
                    </Col>
                    <Col lg="9" md="12">
                        <ProductList filterOption={filterOption} layoutCol={layoutCol}/>
                    </Col>
                </Row>
            </div>
        </div>
    );
}
