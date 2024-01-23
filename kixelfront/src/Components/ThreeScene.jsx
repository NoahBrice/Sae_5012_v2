
import { OrbitControls } from 'three/addons/controls/OrbitControls.js';
// ThreeScene.js
import React, { useEffect } from 'react';
import * as THREE from 'three';

const ThreeScene = () => {
  useEffect(() => {
    // Initialisation de la scène, de la caméra et du rendu
    const scene = new THREE.Scene();

    // Utiliser un aspect ratio approprié pour la taille de la fenêtre
    const aspect = window.innerWidth / window.innerHeight;
    const camera = new THREE.PerspectiveCamera(75, aspect, 0.1, 1000);

    // Utiliser la taille de la fenêtre pour le rendu
    const renderer = new THREE.WebGLRenderer({ alpha: true });
    renderer.setSize(window.innerWidth, window.innerHeight);
    document.body.appendChild(renderer.domElement);

    // Ajout d'un sol
    const groundGeometry = new THREE.PlaneGeometry(100, 100);
    const groundMaterial = new THREE.MeshBasicMaterial({ color: 0x00ff00, side: THREE.DoubleSide });
    const ground = new THREE.Mesh(groundGeometry, groundMaterial);
    ground.rotation.x = Math.PI / 2;
    scene.add(ground);

    // Ajout de blocs représentant les éléments du CMS
    const textBlockGeometry = new THREE.BoxGeometry(1, 1, 1);
    const textBlockMaterial = new THREE.MeshBasicMaterial({ color: 0x0000ff, transparent: true, opacity: 0.5 });
    const textBlock = new THREE.Mesh(textBlockGeometry, textBlockMaterial);
    textBlock.position.set(5, 0, 0);
    scene.add(textBlock);

    // Positionnement de la caméra
    camera.position.z = 5;

    // Rotation automatique de la caméra
    const rotateCamera = () => {
      camera.position.x = Math.cos(Date.now() * 0.001) * 8;
      camera.position.z = Math.sin(Date.now() * 0.001) * 8;
      camera.lookAt(scene.position);
    };

    // Animation
    const animate = () => {
      requestAnimationFrame(animate);

      // Animation des éléments ici

      rotateCamera(); // Rotation automatique de la caméra

      renderer.render(scene, camera);
    };

    animate();

    // Gestion du redimensionnement de la fenêtre
    const handleResize = () => {
      const newAspect = window.innerWidth / window.innerHeight;
      camera.aspect = newAspect;
      camera.updateProjectionMatrix();
      renderer.setSize(window.innerWidth, window.innerHeight);
    };

    // Écouteur d'événement pour le redimensionnement de la fenêtre
    window.addEventListener('resize', handleResize);

    return () => {
      // Retire l'écouteur d'événement lors du démontage du composant
      window.removeEventListener('resize', handleResize);

      // Code de nettoyage (si nécessaire)
      document.body.removeChild(renderer.domElement);
    };
  }, []);

  return null; // Ou tu peux retourner un fragment vide <></>
};

export default ThreeScene;


