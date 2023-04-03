import { useEffect, useState, React } from "react";
import TopContent from "./TopContent";
import RelatedContent from "./RelatedContent";
import Review from "./Review/Review";
import Footer from "../Home/Footer";
import { useParams } from "react-router-dom";
import "../../../css/detail.css";
export default function Detail() {
    const { product_id } = useParams();
    const [spinner, setSpinner] = useState(true);
    useEffect(() => {
        setTimeout(() => {
            setSpinner(false);
        }, 1000);
    }, [])
    if (!spinner) {
        return (
            <div className="detail">
                <TopContent productId={product_id} />
                <Review productId={product_id} />
                <RelatedContent productId={product_id} />
                <Footer />
            </div>
        );
    } else {
        return (
            <div id="spinner" className="container">
                <div className="loading"></div>
            </div>
        );
    }
}
