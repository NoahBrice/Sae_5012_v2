import React, { useState, useEffect } from 'react';
import './ComponentsStyles/Articles.css';

const Articles = () => {
    const [articles, setArticles] = useState([]);
    const [newArticle, setNewArticle] = useState({
        titre: '',
        resume: '',
        position: 0,
    });

    useEffect(() => {
        // Fetch articles API with authentication token
        const token = localStorage.getItem('token');

        if (!token) {
            // Handle case where token is not available (user is not authenticated)
            console.error('Token not available. User not authenticated.');
            return;
        }

        fetch('http://localhost:8000/api/articles', {
            headers: {
                Authorization: `Bearer ${token}`,
            },
        })
            .then((response) => response.json())
            .then((data) => setArticles(data["hydra:member"]))
            .catch((error) => console.error('Error fetching articles:', error));
    }, []);

    const handleInputChange = (event) => {
        const { name, value } = event.target;
        setNewArticle({ ...newArticle, [name]: value });
    };

    const handleSubmit = async (event) => {
        event.preventDefault();

        const token = localStorage.getItem('token');

        if (!token) {
            // Handle case where token is not available (user is not authenticated)
            console.error('Token not available. User not authenticated.');
            return;
        }

        try {
            const response = await fetch('http://localhost:8000/api/articles', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    Authorization: `Bearer ${token}`,
                },
                body: JSON.stringify(newArticle),
            });

            if (response.ok) {
                // Successfully created the new article, you might want to update the UI accordingly
                console.log('Article created successfully');
            } else {
                console.error('Failed to create article');
            }
        } catch (error) {
            console.error('Error during article creation:', error);
        }
    };

    return (
        <div className="articles-container">
            <h1>Articles</h1>
            <div className="article-form">
                <form onSubmit={handleSubmit}>
                    <label htmlFor="titre">Title:</label>
                    <input
                        type="text"
                        id="titre"
                        name="titre"
                        value={newArticle.titre}
                        onChange={handleInputChange}
                    />

                    <label htmlFor="resume">Summary:</label>
                    <textarea
                        id="resume"
                        name="resume"
                        value={newArticle.resume}
                        onChange={handleInputChange}
                    />

                    <label htmlFor="position">Position:</label>
                    <input
                        type="number"
                        id="position"
                        name="position"
                        value={newArticle.position}
                        onChange={handleInputChange}
                    />

                    <button type="submit">Submit</button>
                </form>
            </div>

            <div className="articles-list">
                {articles.map((article) => (
                    <div key={article.id} className="article-item">
                        <h2>{article.titre}</h2>
                        <p>{article.resume}</p>
                        <p>Position: {article.position}</p>
                        {/* Add more details as needed */}
                    </div>
                ))}
            </div>
        </div>
    );
};

export default Articles;
