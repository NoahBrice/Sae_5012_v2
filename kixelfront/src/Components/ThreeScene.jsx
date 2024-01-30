import React, { useEffect, useRef } from 'react';
import * as THREE from 'three';
import { GLTFLoader } from 'three/examples/jsm/loaders/GLTFLoader';
import { EffectComposer } from 'three/examples/jsm/postprocessing/EffectComposer';
import { RenderPass } from 'three/examples/jsm/postprocessing/RenderPass';
import { UnrealBloomPass } from 'three/examples/jsm/postprocessing/UnrealBloomPass';
import { ShaderPass } from 'three/examples/jsm/postprocessing/ShaderPass';
import { OrbitControls } from 'three/examples/jsm/controls/OrbitControls';

const ThreeScene = () => {
  const mountRef = useRef(null);


  useEffect(() => {
    // const audio = new Audio('./public/drumnbass_trop_bien.mp3');
    // audio.play();
    // Initialize scene, camera, and renderer
    const scene = new THREE.Scene();
    const aspect = window.innerWidth / window.innerHeight;
    const camera = new THREE.PerspectiveCamera(75, aspect, 0.1, 1000);
    const renderer = new THREE.WebGLRenderer({ alpha: true });
    renderer.setSize(window.innerWidth, window.innerHeight);

    // Mount renderer to DOM
    const mount = mountRef.current;
    mount.appendChild(renderer.domElement);

    // Composer
    const composer = new EffectComposer(renderer);

    // RenderPass
    const renderPass = new RenderPass(scene, camera);
    composer.addPass(renderPass);

    // BloomPass
    const bloomPass = new UnrealBloomPass();
    composer.addPass(bloomPass);

    // MotionBlur ShaderPass
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
    const motionBlurPass = new ShaderPass(motionBlurShader);
    composer.addPass(motionBlurPass);

    // Ambient Light
    const ambientLight = new THREE.AmbientLight(0xffffff, 0.5);
    scene.add(ambientLight);

    // Directional Light
    const directionalLight = new THREE.DirectionalLight(0xffffff, 1);
    directionalLight.position.set(5, 5, 5);
    scene.add(directionalLight);

    // Load 3D model
    const loader = new GLTFLoader();
    loader.load('./model/low_poly_kiwi_run/scene.gltf', (gltf) => {
      const kiwi = gltf.scene;
      kiwi.scale.set(50, 50, 50);
      kiwi.position.set(3, 2, 4);
      scene.add(kiwi);
    });

    // Box Generator
    class TextBox {
      constructor() {
        this.box = this.createBox();
        this.setRotationSpeed();
        this.addText();
      }

      createBox() {
        const boxGeometry = new THREE.BoxGeometry(5, 5, 5);

        const hue = Math.random() * 0.1 + 0.6; // Adjust the range as needed
        const color = new THREE.Color().setHSL(hue, 0.7, 0.5);
        const boxMaterial = new THREE.MeshStandardMaterial({
          color: color,
          metalness: 1,
          roughness: 0.5,
        });
        return new THREE.Mesh(new THREE.BoxGeometry(5, 5, 5), boxMaterial);
      }

      setRotationSpeed() {
        // Set a slower rotation speed
        this.box.rotationSpeedX = Math.random() * 0.005;
        this.box.rotationSpeedY = Math.random() * 0.005;
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

    function generateBoxes() {
      for (let i = 0; i < 69; i++) {
        const textBox = new TextBox();
        textBox.box.position.x = Math.random() * 80 - 40;
        textBox.box.position.z = Math.random() * 80 - 40;
        textBox.box.position.y = Math.random() * 80 - 40;
        scene.add(textBox.box);
      }
    }

    // Boxes
    generateBoxes();
    // Create a particle geometry (e.g., points)
    const particleGeometry = new THREE.BufferGeometry();
    const vertices = []; // Array to store particle positions
    const cameraMovementSpeed = 0.001; // Adjust this value to control the speed of camera movement

    let cameraRotation = 0;

    function animateCamera() {
      // Calculate new camera position
      const newX = Math.sin(cameraRotation) * 50; // Adjust the radius as needed
      const newZ = Math.cos(cameraRotation) * 50; // Adjust the radius as needed
      const newY = 30; // Adjust the height as needed

      // Update camera position
      camera.position.x += (newX - camera.position.x) * cameraMovementSpeed;
      camera.position.y += (newY - camera.position.y) * cameraMovementSpeed;
      camera.position.z += (newZ - camera.position.z) * cameraMovementSpeed;

      // Increment camera rotation
      cameraRotation += 0.0015; // Adjust the rotation speed as needed

      // Update camera lookAt position
      camera.lookAt(scene.position);
    }

    // Add random particle positions
    for (let i = 0; i < 1000; i++) {
      const x = Math.random() * 100 - 50;
      const y = Math.random() * 100 - 50;
      const z = Math.random() * 100 - 50;
      vertices.push(x, y, z);
    }

    particleGeometry.setAttribute('position', new THREE.Float32BufferAttribute(vertices, 3));

    // Define particle material
    const particleMaterial = new THREE.PointsMaterial({
      color: 0x2d4ca8,
      size: 1,
      transparent: true,
      opacity: 0.8,
    });

    // Create particle system
    const particleSystem = new THREE.Points(particleGeometry, particleMaterial);

    // Add particle system to the scene
    scene.add(particleSystem);

    // Add some movement and animation to the particles
    function animateParticles() {
      const positionsArray = particleGeometry.attributes.position.array;

      // Adjust the speed of movement by scaling the factor
      const speedFactor = 0.003; // Adjust this value to control the speed

      // Update the positions of the particles
      for (let i = 0; i < positionsArray.length; i += 3) {
        // Update the x, y, and z positions of each particle
        positionsArray[i] += (Math.random() - 0.8) * speedFactor; // x-coordinate
        positionsArray[i + 1] += (Math.random() - 0.8) * speedFactor; // y-coordinate
        positionsArray[i + 2] += (Math.random() - 0.8) * speedFactor; // z-coordinate
      }

      // Update the attribute buffer
      particleGeometry.attributes.position.needsUpdate = true;

      // Schedule next animation frame
      requestAnimationFrame(animateParticles);
    }

    // Start the particle animation
    animateParticles();



    // Camera
    camera.position.z = 30;

    // OrbitControls
    const controls = new OrbitControls(camera, renderer.domElement);
    controls.enableDamping = true;
    controls.dampingFactor = 0.25;
    controls.screenSpacePanning = false;
    controls.maxPolarAngle = Math.PI / 2;

    // Animation Loop
    const animate = () => {

      requestAnimationFrame(animate);
      animateCamera();
      // Rotate Boxes
      scene.children.forEach((object) => {
        if (object instanceof THREE.Mesh) {
          object.rotation.x += object.rotationSpeedX;
          object.rotation.y += object.rotationSpeedY;
        }
      });

      // Update Mixer (if using animations)
      // composer.render();
      renderer.render(scene, camera);
    };

    animate();

    // Resize Handler
    const handleResize = () => {
      const newAspect = window.innerWidth / window.innerHeight;
      camera.aspect = newAspect;
      camera.updateProjectionMatrix();
      renderer.setSize(window.innerWidth, window.innerHeight);
    };

    window.addEventListener('resize', handleResize);

    // Cleanup
    return () => {
      mount.removeChild(renderer.domElement);
      window.removeEventListener('resize', handleResize);
    };
  }, []);

  return <div ref={mountRef} className='scene' />;
};

export default ThreeScene;

