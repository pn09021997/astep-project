import React from 'react'
import "../../../css/Info.css";
export default function Info({ isLogin }) {
    return (
        <div className="info mt-5 mb-5">
            {JSON.stringify(isLogin)}
        </div>
    )
}
