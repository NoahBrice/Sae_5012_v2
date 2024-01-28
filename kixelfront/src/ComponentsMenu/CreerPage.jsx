import React, { useState, useEffect } from 'react';
import './ComponentsStyles/PageCreation.css';

const PageCreation = () => {
    const [articles, setArticles] = useState([]);
    const [sites, setSites] = useState([]);
    const [pageData, setPageData] = useState({
        nom: '',
        article: [],
        site: '',
    });

    useEffect(() => {
        const token = localStorage.getItem('token');

        if (!token) {
            console.error('Token not available. User not authenticated.');
            return;
        }

        // Fetch articles
        fetch('http://localhost:8000/api/articles', {
            headers: {
                Authorization: `Bearer ${token}`,
            },
        })
            .then((response) => response.json())
            .then((data) => setArticles(data["hydra:member"]))
            .catch((error) => console.error('Error fetching articles:', error));

        // Fetch sites
        fetch('http://localhost:8000/api/sites', {
            headers: {
                Authorization: `Bearer ${token}`,
            },
        })
            .then((response) => response.json())
            .then((data) => setSites(data["hydra:member"]))
            .catch((error) => console.error('Error fetching sites:', error));
    }, []);

    const handleInputChange = (event) => {
        const { name, value } = event.target;
        setPageData({
            ...pageData,
            [name]: value,
        });
        console.log(pageData);
    };

    const handleSelectChange = (event) => {
        const { name, options } = event.target;
        const selectedValues = Array.from(options)
            .filter((option) => option.selected)
            .map((option) => option.value);
        setPageData({
            ...pageData,
            [name]: selectedValues,
        });
    };
    

    const handleSubmit = async (event) => {
        event.preventDefault();
        const token = localStorage.getItem('token');
        if (!token) {
            console.error('Token not available. User not authenticated.');
            return;
        }
        try {
            const response = await fetch('http://localhost:8000/api/pages', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    Authorization: `Bearer ${token}`,
                },
                body: JSON.stringify(pageData),
            });
            if (response.ok) {
                console.log('Page created successfully');
                // Add logic to handle successful page creation
            } else {
                console.error('Failed to create page');
            }
        } catch (error) {
            console.error('Error during page creation:', error);
        }
    };

    return (
        <div className="page-creation-container">
            <h1>Create a Page</h1>
            <form onSubmit={handleSubmit}>
                <div className="form-group">
                    <label htmlFor="nom">Page Name:</label>
                    <input
                        type="text"
                        id="nom"
                        name="nom"
                        value={pageData.nom}
                        onChange={handleInputChange}
                        required
                    />
                </div>
                <div className="form-group">
                    <label htmlFor="article">Select Articles:</label>
                    <select
                        id="article"
                        name="article"
                        multiple
                        value={pageData.article}
                        onChange={handleSelectChange}
                        required
                    >
                        {articles.map((article) => (
                            <option key={article['@id']} value={article['@id']}>
                                {article.titre}
                            </option>
                        ))}
                    </select>
                </div>
                <div className="form-group">
                    <label htmlFor="site">Select Site:</label>
                    <select
                        id="site"
                        name="site"
                        value={pageData.site}
                        onChange={handleInputChange}
                        required
                    >
                        {sites.map((site) => (
                            <option key={site['@id']} value={site['@id']}>
                                {site.nom}
                            </option>
                        ))}
                    </select>
                </div>
                <button type="submit">Create Page</button>
            </form>
        </div>
    );
};

export default PageCreation;


