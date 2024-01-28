import React, { useState, useEffect } from 'react';
import './ComponentsStyles/Pages.css';

const Pages = () => {
    const [pages, setPages] = useState([]);
    const [articles, setArticles] = useState([]);

    useEffect(() => {
        const token = localStorage.getItem('token');

        if (!token) {
            console.error('Token not available. User not authenticated.');
            return;
        }

        const fetchPages = async () => {
            try {
                const response = await fetch('http://localhost:8000/api/pages', {
                    headers: {
                        Authorization: `Bearer ${token}`,
                    },
                });

                if (!response.ok) {
                    throw new Error('Failed to fetch pages');
                }

                const data = await response.json();
                setPages(data["hydra:member"]);
            } catch (error) {
                console.error('Error fetching pages:', error);
            }
        };

        fetchPages();
    }, []);

    const fetchArticlesForPage = async (pageId) => {
        const token = localStorage.getItem('token');

        if (!token) {
            console.error('Token not available. User not authenticated.');
            return;
        }

        try {
            const response = await fetch(`http://localhost:8000/api/pages/${pageId}/articles`, {
                headers: {
                    Authorization: `Bearer ${token}`,
                },
            });

            if (!response.ok) {
                throw new Error('Failed to fetch articles for page');
            }

            const data = await response.json();
            setArticles(data["hydra:member"]);
        } catch (error) {
            console.error(`Error fetching articles for page ${pageId}:`, error);
        }
    };

    const handlePageClick = (pageId) => {
        fetchArticlesForPage(pageId);
    };

    return (
        <div className="pages-container">
            <h1>Pages</h1>
            <div className="pages-list">
                {pages.map((page) => (
                    <div key={page.id} className="page-item" onClick={() => handlePageClick(page.id)}>
                        <h2>{page.nom}</h2>
                        <div className="articles-preview">
                            <h3>Articles</h3>
                            {articles.map((article) => (
                                <div key={article.id} className="article-preview">
                                    <p>{article.titre}</p>
                                    <p>{article.resume}</p>
                                    <p>{article.position}</p>
                                </div>
                            ))}
                        </div>
                    </div>
                ))}
            </div>
        </div>
    );
};

export default Pages;

