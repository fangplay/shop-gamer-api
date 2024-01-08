import React from "react";
import Layout from "../resources/js/components/Layout";
import Header from "../resources/js/components/Header";

export default function Index() {
    return (
        <>
            <Header />
            <Layout />
            <div className="mt-20">
                <p>Welcome to beta shop website.</p>
            </div>
        </>
    );
};
