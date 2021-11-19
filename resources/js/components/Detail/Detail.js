import React from 'react';
import TopContent from './TopContent';
import RelatedContent from './RelatedContent';
import ReviewComment from './ReviewComment';
export default function Detail() {
    return (
        <div className="detail">
            <TopContent/>
            <RelatedContent/>
            <ReviewComment/>
        </div>
    )
}
