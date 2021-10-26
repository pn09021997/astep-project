import React from 'react'
import "../../../css/Info.css";
export default function Info({ isLogin }) {
    return (
        <div className="info">
            {JSON.stringify(isLogin)}
        </div>
    )
}
