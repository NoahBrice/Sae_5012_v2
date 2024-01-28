import React, { useState, useEffect } from 'react';
import './ComponentsStyles/Articles.css';

const Articles = () => {
    const [articles, setArticles] = useState([]);
    const [blocs, setBlocs] = useState([]);
    const [pages, setPages] = useState([]);
    const [types, setTypes] = useState([]); // New state for bloc types
    const [newArticle, setNewArticle] = useState({
        titre: '',
        resume: '',
        position: 0,
        pages: [],
        blocs: [],
    });
    const [newBloc, setNewBloc] = useState({
        typeBloc: '',
        titre: '',
        contenu: '',
    });
    const [showForm, setShowForm] = useState(false); // State to control form visibility
    const [showNewBlocForm, setShowNewBlocForm] = useState(false); // State to control new bloc form visibility

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

        // Fetch blocs
        fetch('http://localhost:8000/api/blocs', {
            headers: {
                Authorization: `Bearer ${token}`,
            },
        })
            .then((response) => response.json())
            .then((data) => setBlocs(data["hydra:member"]))
            .catch((error) => console.error('Error fetching blocs:', error));

        // Fetch pages
        fetch('http://localhost:8000/api/pages', {
            headers: {
                Authorization: `Bearer ${token}`,
            },
        })
            .then((response) => response.json())
            .then((data) => setPages(data["hydra:member"]))
            .catch((error) => console.error('Error fetching pages:', error));

        // Fetch bloc types
        fetch('http://localhost:8000/api/type_blocs', {
            headers: {
                Authorization: `Bearer ${token}`,
            },
        })
            .then((response) => response.json())
            .then((data) => setTypes(data["hydra:member"]))
            .catch((error) => console.error('Error fetching bloc types:', error));
    }, []);

    const handleInputChange = (event) => {

        const { name, value } = event.target;
        console.log(name, value);
        const article2 = {
            ...newArticle,
            [name]: (name === "position") && value ? Number(value) : value
        }
        setNewArticle({ ...article2 });
        console.log(newArticle);
    };

    const handleSelectChange = (event) => {
        const { name, options } = event.target;
        const selectedValues = Array.from(options)
            .filter((option) => option.selected)
            .map((option) => option.value);
        setNewArticle({
            ...newArticle,
            [name]: selectedValues,
        });
    };

    const handleToggleForm = () => {
        setShowForm(!showForm);
    };

    const handleToggleNewBlocForm = () => {
        setShowNewBlocForm(!showNewBlocForm);
    };

    const handleBlocTypeChange = (event) => {
        const { value } = event.target;
        setNewBloc({
            ...newBloc,
            typeBloc: value,
        });
        console.log(newBloc);
    };

    const handleNewBlocSubmit = async (event) => {
        event.preventDefault();
        const token = localStorage.getItem('token');
        if (!token) {
            console.error('Token not available. User not authenticated.');
            return;
        }
        try {
            const response = await fetch('http://localhost:8000/api/blocs', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    Authorization: `Bearer ${token}`,
                },
                body: JSON.stringify(newBloc),
            });
            if (response.ok) {
                console.log('New bloc created successfully');
                // Refresh the blocs list after creating a new bloc
                const updatedBlocs = await fetch('http://localhost:8000/api/blocs', {
                    headers: {
                        Authorization: `Bearer ${token}`,
                    },
                }).then((response) => response.json());
                setBlocs(updatedBlocs["hydra:member"]);
            } else {
                console.error('Failed to create new bloc');
            }
        } catch (error) {
            console.error('Error during new bloc creation:', error);
        }
    };

    const handleSubmit = async (event) => {
        event.preventDefault();
        const token = localStorage.getItem('token');
        if (!token) {
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
                console.log('Article created successfully');
                // Refresh the articles list after creating a new article
                const updatedArticles = await fetch('http://localhost:8000/api/articles', {
                    headers: {
                        Authorization: `Bearer ${token}`,
                    },
                }).then((response) => response.json());
                setArticles(updatedArticles["hydra:member"]);
                setShowForm(false); // Close form after successful submission
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

            <div className='main-form'>
                {showForm && (
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

                            <label htmlFor="pages">Select Pages:</label>
                            <select
                                id="pages"
                                name="pages"
                                multiple
                                value={newArticle.pages}
                                onChange={handleSelectChange}
                            >
                                {pages.map((page) => (
                                    <option key={page.id} value={page['@id']}>
                                        {page.nom}
                                    </option>
                                ))}
                            </select>

                            <label htmlFor="blocs">Select Blocs:</label>
                            <select
                                id="blocs"
                                name="blocs"
                                multiple
                                value={newArticle.blocs}
                                onChange={handleSelectChange}
                            >
                                {blocs.map((bloc) => (
                                    <option key={bloc.id} value={bloc['@id']}>
                                        Type bloc ({bloc.nom}) | Contenu : {bloc.titre} {bloc.contenu}
                                    </option>
                                ))}
                            </select>

                            <div>
                                <span>OR</span>
                                <button type="button" onClick={handleToggleNewBlocForm}>
                                    Create a new bloc
                                </button>
                            </div>

                            <button type="submit">Submit</button>
                        </form>
                        {showNewBlocForm && (
                            <form onSubmit={handleNewBlocSubmit}>
                                <label htmlFor="typeBloc">Select Bloc Type:</label>
                                <select
                                    id="typeBloc"
                                    name="typeBloc"
                                    value={newBloc.typeBloc}
                                    onChange={handleBlocTypeChange}
                                >
                                    {types.map((type) => (
                                        <option key={type.id} value={type['@id']}>
                                            {type.nom}
                                        </option>
                                    ))}
                                </select>

                                {/* Render additional fields based on bloc type */}
                                {newBloc.typeBloc === '/api/type_blocs/5' && (
                                    <input
                                        type="text"
                                        id="titre"
                                        name="titre"
                                        placeholder="Enter title"
                                        value={newBloc.titre}
                                        onChange={(e) => setNewBloc({ ...newBloc, titre: e.target.value })}
                                    />
                                )}
                                {newBloc.typeBloc === '/api/type_blocs/4' && (
                                    <textarea
                                        id="contenu"
                                        name="contenu"
                                        placeholder="Enter text"
                                        value={newBloc.contenu}
                                        onChange={(e) => setNewBloc({ ...newBloc, contenu: e.target.value })}
                                    />
                                )}
                                {newBloc.typeBloc === '/api/type_blocs/2' && (
                                    <input
                                        type="file"
                                        id="image"
                                        name="image"
                                        accept="image/*"
                                        onChange={(e) => console.log(e.target.files[0])} // Handle image upload
                                    />
                                )}
                                {newBloc.typeBloc === '/api/type_blocs/3"' && (
                                    <p>Test dashboard</p>
                                )}

                                <button type="submit">Create</button>
                            </form>
                        )}

                    </div>
                )}

            </div>
            <div className="articles-list">
                <div className="article-form-toggle" onClick={handleToggleForm}>
                    <span>{showForm ? '✕' : '+'}</span>
                </div>
                {articles.map((article) => {

                    return (
                        <div key={article.id} className="article-item">
                            <h2>{article.titre}</h2>
                            <p>{article.resume}</p>
                            <p>Position: {article.position}</p>
                            <p>Pages: {article.pages.join(', ')}</p>
                            <p>Blocs: {article.blocs.join(', ')}</p>
                        </div>
                    );
                })}
            </div>



        </div>
    );
};

export default Articles;
