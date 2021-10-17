import React from 'react'

export default function Info({ isLogin }) {
    return (
        <div className="info">
            {JSON.stringify(isLogin)}
        </div>
    )
}
