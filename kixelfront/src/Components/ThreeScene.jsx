
import { OrbitControls } from 'three/addons/controls/OrbitControls.js';
// ThreeScene.js
import React, { useEffect } from 'react';
import * as THREE from 'three';
import { GLTFLoader } from 'three/addons/loaders/GLTFLoader.js';
import { EffectComposer } from 'three/addons/postprocessing/EffectComposer.js';
import { ShaderPass } from 'three/addons/postprocessing/ShaderPass.js';
import { RenderPass } from 'three/addons/postprocessing/RenderPass.js';
import { UnrealBloomPass } from 'three/addons/postprocessing/UnrealBloomPass.js';
import { CopyShader } from 'three/addons/shaders/CopyShader.js';
// import { RoundedBoxGeometry } from './three/examples/jsm/geometries/RoundedBoxGeometry.js';

const ThreeScene = () => {
  useEffect(() => {

    // init scene, de la caméra et du rendu
    const scene = new THREE.Scene();

    // ratio approprié 
    const aspect = window.innerWidth / window.innerHeight;
    const camera = new THREE.PerspectiveCamera(75, aspect, 0.1, 1000);

    // taille de la fenêtre pour rendu
    const renderer = new THREE.WebGLRenderer({ alpha: true });
    renderer.setSize(window.innerWidth, window.innerHeight);
    document.body.appendChild(renderer.domElement);

    // composer de mort (pas php xdddd)
    const composer = new EffectComposer(renderer);

    // RenderPass 
    const renderPass = new RenderPass(scene, camera);
    composer.addPass(renderPass);

    // ShaderPass 
    const motionBlurShader = {
      uniforms: {
        tDiffuse: { value: null },
        tVelocity: { value: null },
        velocityFactor: { value: 15 },
        sigma: { value: 15 },
      },
      vertexShader: `
        varying vec2 vUv;
        void main() {
            vUv = uv;
            gl_Position = projectionMatrix * modelViewMatrix * vec4(position, 1.0);
        }
    `,
      fragmentShader: `
        uniform sampler2D tDiffuse;
        uniform sampler2D tVelocity;
        uniform float velocityFactor;
        uniform float sigma;
        varying vec2 vUv;
        void main() {
            vec2 velocity = texture2D(tVelocity, vUv).xy * velocityFactor;
            vec4 result = texture2D(tDiffuse, vUv);
            for(float t = -30.0; t <= 30.0; t += 1.0) {
                result += texture2D(tDiffuse, vUv + velocity * t * sigma);
            }
            gl_FragColor = result / 61.0;
        }
    `,
    };

    // Ajout d'un sol incliné
    const groundGeometry = new THREE.PlaneGeometry(200, 200);
    const groundMaterial = new THREE.MeshBasicMaterial({ color: 0x005300, side: THREE.DoubleSide });
    const ground = new THREE.Mesh(groundGeometry, groundMaterial);
    ground.rotation.x = - Math.PI / 2; // Incliner le sol
    scene.add(ground);

    // lumière ambiante
    const ambientLight = new THREE.AmbientLight(0xffffff, 0.5);
    scene.add(ambientLight);

    // lumière directionnelle
    const directionalLight = new THREE.DirectionalLight(0xffffff, 1);
    directionalLight.position.set(5, 5, 5);
    scene.add(directionalLight);

    // Chargement du modèle 3D de kiwi
    const loader = new GLTFLoader();
    let kiwi;
    let mixer;

    loader.load('model/low_poly_kiwi_run/scene.gltf', (gltf) => {
      kiwi = gltf.scene;
      kiwi.scale.set(50, 50, 50); // taille kiwi
      kiwi.position.set(1, 0.5, 1); // position
      scene.add(kiwi);

      // Initialiser le mixer pour les animations
      mixer = new THREE.AnimationMixer(kiwi);
      gltf.animations.forEach((clip) => {
        mixer.clipAction(clip).play();
      });
    });

    // Fonction pour générer deux arbres avec feuillage
    function generateTrees() {
      for (let i = 0; i < 5; i++) {
        const treeGeometry = new THREE.CylinderGeometry(1, 1, 10, 8);
        const treeMaterial = new THREE.MeshBasicMaterial({ color: 0x8B4513 }); // marron
        const tree = new THREE.Mesh(treeGeometry, treeMaterial);

        // feuillage aux arbres
        const leavesGeometry = new THREE.SphereGeometry(3, 8, 4);
        const leavesMaterial = new THREE.MeshBasicMaterial({ color: 0x00ff00 });
        const leaves = new THREE.Mesh(leavesGeometry, leavesMaterial);
        leaves.position.y = 5; //  feuilles au-dessus du tronc
        tree.add(leaves);

        //  aléatoire sur le sol
        tree.position.x = Math.random() * 80 - 40;
        tree.position.z = Math.random() * 80 - 80;

        //  la taille des arbres
        tree.scale.set(4, 4, 4);

        scene.add(tree);
      }
    }

    //  trois boîtes avec des faces arrondies
    class TextBox {
      constructor() {
        this.box = this.createBox();
        this.setRotationSpeed();
        this.addText();
      }

      createBox() {
        const boxGeometry = new THREE.BoxGeometry(5, 5, 5);
        const boxMaterial = new THREE.MeshBasicMaterial({ color: Math.random() * 0xffffff });
        return new THREE.Mesh(boxGeometry, boxMaterial);
      }

      setRotationSpeed() {
        this.box.rotationSpeedX = Math.random() * 0.2;
        this.box.rotationSpeedY = Math.random() * 0.2;
      }

      addText() {
        const blockNames = ['<Article>', '<p>', '<title>', '<div>', '<img>', '<ul>', '<li>'];
        const blockText = blockNames[Math.floor(Math.random() * blockNames.length)];
        const blockCanvas = document.createElement('canvas');
        const blockContext = blockCanvas.getContext('2d');
        blockCanvas.width = 128;
        blockCanvas.height = 64;
        blockContext.fillStyle = 'white';
        blockContext.fillRect(0, 0, blockCanvas.width, blockCanvas.height);
        blockContext.font = '25px Verdana';
        blockContext.fillStyle = 'black';
        blockContext.fillText(blockText, 15, 30);
        const blockTexture = new THREE.CanvasTexture(blockCanvas);
        this.box.material.map = blockTexture;
        this.box.material.needsUpdate = true;
      }
    }

    function generateTorusKnots() {
      for (let i = 0; i < 12; i++) {
        const torusKnotGeometry = new THREE.TorusKnotGeometry(5, 1, 100, 16);
        const torusKnotMaterial = new THREE.MeshBasicMaterial({ color: Math.random() * 0xffffff });

        const torusKnot = new THREE.Mesh(torusKnotGeometry, torusKnotMaterial);
        torusKnot.position.x = Math.random() * 80 - 40;
        torusKnot.position.y = Math.random() * 40 + 30; // Ajuster la hauteur selon vos besoins
        torusKnot.position.z = Math.random() * 80 - 40;

        scene.add(torusKnot);
      }
    }

    function generateBoxes() {
      for (let i = 0; i < 7; i++) {
        const textBox = new TextBox();
        textBox.box.position.x = Math.random() * 80 - 40;
        textBox.box.position.z = Math.random() * 80 - 40;
        textBox.box.position.y = 5;
        const rotationSpeedX = Math.random() * 0.2;
        const rotationSpeedY = Math.random() * 0.2;

        scene.add(textBox.box);
      }
    }

    // TorusKnots (j'adore ce mot)
    generateTorusKnots();
    // aaarabres et les boîtes
    generateTrees();
    generateBoxes();

    // caméra
    camera.position.z = 30;

    // OrbitControls pour l'interaction
    const controls = new OrbitControls(camera, renderer.domElement);
    controls.enableDamping = true; //animation loop(pour el kiwito)
    controls.dampingFactor = 0.25;
    controls.screenSpacePanning = false;
    controls.maxPolarAngle = Math.PI / 2;

    const motionBlurPass = new ShaderPass(motionBlurShader);
    composer.addPass(motionBlurPass);

    // UnrealBloomPass pour un effet de bloom (optionnel) (ca marche pas frrrrrrrrr)
    const bloomPass = new UnrealBloomPass();
    composer.addPass(bloomPass);

    // Animation
    const animate = () => {
      requestAnimationFrame(animate);

      // mixer pour les animations
      if (mixer) {
        mixer.update(0.01);
      }

      scene.children.forEach((object) => {
        if (object instanceof TextBox) {
          object.box.rotation.x += object.box.rotationSpeedX;
          object.box.rotation.y += object.box.rotationSpeedY;
        }
      });

      //  OrbitControls
      controls.update();

      // scène avec le composer askip faut ça jsp
      composer.render();

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
  });
}
export default ThreeScene;