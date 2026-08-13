document.addEventListener('DOMContentLoaded', () => {
  // 0. Fetch Dynamic Site Settings
  fetch('http://localhost:8083/get_settings.php')
    .then(res => res.json())
    .then(data => {
      if (data.success && data.data) {
        const settings = data.data;
        if (settings.hero_badge && document.getElementById('heroBadgeText')) document.getElementById('heroBadgeText').textContent = settings.hero_badge;
        if (settings.hero_title1 && document.getElementById('heroTitle1')) document.getElementById('heroTitle1').textContent = settings.hero_title1;
        if (settings.hero_title1_hi && document.getElementById('heroTitle1Hi')) document.getElementById('heroTitle1Hi').textContent = settings.hero_title1_hi;
        if (settings.hero_title2 && document.getElementById('heroTitle2')) document.getElementById('heroTitle2').textContent = settings.hero_title2;
        if (settings.hero_title2_hi && document.getElementById('heroTitle2Hi')) document.getElementById('heroTitle2Hi').textContent = settings.hero_title2_hi;
        if (settings.hero_desc && document.getElementById('heroSubtitle')) document.getElementById('heroSubtitle').textContent = settings.hero_desc;

        // Update Academic Programs Section
        if (settings.prog_tag && document.getElementById('progTag')) document.getElementById('progTag').textContent = settings.prog_tag;
        if (settings.prog_title && document.getElementById('progTitle')) document.getElementById('progTitle').textContent = settings.prog_title;
        if (settings.prog_desc && document.getElementById('progDesc')) document.getElementById('progDesc').textContent = settings.prog_desc;
        
        // Prog 1
        if (settings.prog1_icon && document.getElementById('prog1Icon')) document.getElementById('prog1Icon').className = 'fas ' + settings.prog1_icon;
        if (settings.prog1_title && document.getElementById('prog1Title')) document.getElementById('prog1Title').textContent = settings.prog1_title;
        if (settings.prog1_desc && document.getElementById('prog1Desc')) document.getElementById('prog1Desc').textContent = settings.prog1_desc;
        if (settings.prog1_tag1 && document.getElementById('prog1Tag1')) document.getElementById('prog1Tag1').textContent = settings.prog1_tag1;
        if (settings.prog1_tag2 && document.getElementById('prog1Tag2')) document.getElementById('prog1Tag2').textContent = settings.prog1_tag2;
        if (settings.prog1_tag3 && document.getElementById('prog1Tag3')) document.getElementById('prog1Tag3').textContent = settings.prog1_tag3;
        
        // Prog 2
        if (settings.prog2_icon && document.getElementById('prog2Icon')) document.getElementById('prog2Icon').className = 'fas ' + settings.prog2_icon;
        if (settings.prog2_title && document.getElementById('prog2Title')) document.getElementById('prog2Title').textContent = settings.prog2_title;
        if (settings.prog2_desc && document.getElementById('prog2Desc')) document.getElementById('prog2Desc').textContent = settings.prog2_desc;
        if (settings.prog2_tag1 && document.getElementById('prog2Tag1')) document.getElementById('prog2Tag1').textContent = settings.prog2_tag1;
        if (settings.prog2_tag2 && document.getElementById('prog2Tag2')) document.getElementById('prog2Tag2').textContent = settings.prog2_tag2;
        if (settings.prog2_tag3 && document.getElementById('prog2Tag3')) document.getElementById('prog2Tag3').textContent = settings.prog2_tag3;
        
        // Prog 3
        if (settings.prog3_icon && document.getElementById('prog3Icon')) document.getElementById('prog3Icon').className = 'fas ' + settings.prog3_icon;
        if (settings.prog3_title && document.getElementById('prog3Title')) document.getElementById('prog3Title').textContent = settings.prog3_title;
        if (settings.prog3_desc && document.getElementById('prog3Desc')) document.getElementById('prog3Desc').textContent = settings.prog3_desc;
        if (settings.prog3_tag1 && document.getElementById('prog3Tag1')) document.getElementById('prog3Tag1').textContent = settings.prog3_tag1;
        if (settings.prog3_tag2 && document.getElementById('prog3Tag2')) document.getElementById('prog3Tag2').textContent = settings.prog3_tag2;
        if (settings.prog3_tag3 && document.getElementById('prog3Tag3')) document.getElementById('prog3Tag3').textContent = settings.prog3_tag3;
      }
    })
    .catch(err => console.error('Error fetching settings:', err));

  // 0.5 THEME SWITCHER MANAGEMENT (Default Base: Dark Theme)
  const themeToggle = document.getElementById('themeToggle');
  const htmlEl = document.documentElement;

  // Restore saved theme or default to 'dark'
  const savedTheme = localStorage.getItem('kptc_it_theme') || 'dark';
  htmlEl.setAttribute('data-theme', savedTheme);

  if (themeToggle) {
    themeToggle.addEventListener('click', () => {
      const currentTheme = htmlEl.getAttribute('data-theme');
      const newTheme = currentTheme === 'light' ? 'dark' : 'light';
      htmlEl.setAttribute('data-theme', newTheme);
      localStorage.setItem('kptc_it_theme', newTheme);
    });
  }

  // 1. Mobile Menu Toggle
  const menuToggle = document.getElementById('menuToggle');
  const navLinks = document.getElementById('navLinks');

  if (menuToggle && navLinks) {
    menuToggle.addEventListener('click', () => {
      navLinks.classList.toggle('active');
      const icon = menuToggle.querySelector('i');
      if (icon) {
        icon.className = navLinks.classList.contains('active') ? 'fas fa-times' : 'fas fa-bars';
      }
    });
  }

  // 2. Navbar Scroll Effect
  const navbar = document.querySelector('.navbar');
  window.addEventListener('scroll', () => {
    if (window.scrollY > 50) {
      navbar?.classList.add('scrolled');
    } else {
      navbar?.classList.remove('scrolled');
    }
  });

  // 3. 2D Hero Particle Background System
  const canvas = document.getElementById('heroCanvas');
  if (canvas) {
    const ctx = canvas.getContext('2d');
    let width = (canvas.width = window.innerWidth);
    let height = (canvas.height = window.innerHeight);

    window.addEventListener('resize', () => {
      width = canvas.width = window.innerWidth;
      height = canvas.height = window.innerHeight;
    });

    const particles = [];
    const particleCount = Math.min(Math.floor(width / 18), 70);

    for (let i = 0; i < particleCount; i++) {
      particles.push({
        x: Math.random() * width,
        y: Math.random() * height,
        vx: (Math.random() - 0.5) * 0.8,
        vy: (Math.random() - 0.5) * 0.8,
        radius: Math.random() * 2 + 1,
        alpha: Math.random() * 0.5 + 0.3
      });
    }

    function animateParticles() {
      ctx.clearRect(0, 0, width, height);
      const isDark = htmlEl.getAttribute('data-theme') === 'dark';

      // Grid lines
      ctx.strokeStyle = isDark ? 'rgba(0, 242, 254, 0.03)' : 'rgba(2, 132, 199, 0.04)';
      ctx.lineWidth = 1;
      const gridSize = 60;
      for (let x = 0; x < width; x += gridSize) {
        ctx.beginPath();
        ctx.moveTo(x, 0);
        ctx.lineTo(x, height);
        ctx.stroke();
      }
      for (let y = 0; y < height; y += gridSize) {
        ctx.beginPath();
        ctx.moveTo(0, y);
        ctx.lineTo(width, y);
        ctx.stroke();
      }

      // Nodes & Connections
      const nodeColor = isDark ? '0, 242, 254' : '2, 132, 199';
      for (let i = 0; i < particles.length; i++) {
        const p1 = particles[i];
        p1.x += p1.vx;
        p1.y += p1.vy;

        if (p1.x < 0 || p1.x > width) p1.vx *= -1;
        if (p1.y < 0 || p1.y > height) p1.vy *= -1;

        ctx.fillStyle = `rgba(${nodeColor}, ${p1.alpha})`;
        ctx.beginPath();
        ctx.arc(p1.x, p1.y, p1.radius, 0, Math.PI * 2);
        ctx.fill();

        for (let j = i + 1; j < particles.length; j++) {
          const p2 = particles[j];
          const dx = p1.x - p2.x;
          const dy = p1.y - p2.y;
          const dist = Math.sqrt(dx * dx + dy * dy);

          if (dist < 130) {
            ctx.strokeStyle = `rgba(${nodeColor}, ${1 - dist / 130 * 0.25})`;
            ctx.lineWidth = 0.6;
            ctx.beginPath();
            ctx.moveTo(p1.x, p1.y);
            ctx.lineTo(p2.x, p2.y);
            ctx.stroke();
          }
        }
      }

      requestAnimationFrame(animateParticles);
    }

    animateParticles();
  }

  // 4. THREE.JS 3D INTERACTIVE CYBER CORE
  const webglCanvas = document.getElementById('webgl3d');
  if (webglCanvas && typeof THREE !== 'undefined') {
    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(45, 1, 0.1, 1000);
    camera.position.z = 4.6;

    const renderer = new THREE.WebGLRenderer({
      canvas: webglCanvas,
      alpha: true,
      antialias: true
    });
    renderer.setSize(220, 220);
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));

    // Outer Cyber Wireframe Sphere
    const sphereGeo = new THREE.IcosahedronGeometry(1.2, 2);
    const sphereMat = new THREE.MeshBasicMaterial({
      color: 0x00f2fe,
      wireframe: true,
      transparent: true,
      opacity: 0.5
    });
    const cyberSphere = new THREE.Mesh(sphereGeo, sphereMat);
    scene.add(cyberSphere);

    // Inner Glowing Core Node
    const innerGeo = new THREE.IcosahedronGeometry(0.75, 1);
    const innerMat = new THREE.MeshBasicMaterial({
      color: 0x7f00ff,
      wireframe: true,
      transparent: true,
      opacity: 0.65
    });
    const innerCore = new THREE.Mesh(innerGeo, innerMat);
    scene.add(innerCore);

    // Outer Rotating Tech Ring 1
    const ringGeo1 = new THREE.TorusGeometry(1.55, 0.02, 16, 100);
    const ringMat1 = new THREE.MeshBasicMaterial({
      color: 0x00f2fe,
      transparent: true,
      opacity: 0.8
    });
    const techRing1 = new THREE.Mesh(ringGeo1, ringMat1);
    techRing1.rotation.x = Math.PI / 3;
    scene.add(techRing1);

    // Outer Rotating Tech Ring 2
    const ringGeo2 = new THREE.TorusGeometry(1.68, 0.012, 16, 100);
    const ringMat2 = new THREE.MeshBasicMaterial({
      color: 0x7f00ff,
      transparent: true,
      opacity: 0.7
    });
    const techRing2 = new THREE.Mesh(ringGeo2, ringMat2);
    techRing2.rotation.y = Math.PI / 4;
    scene.add(techRing2);

    // Floating 3D Node Points
    const particlesGeo = new THREE.BufferGeometry();
    const particleCount3D = 45;
    const posArray = new Float32Array(particleCount3D * 3);

    for (let i = 0; i < particleCount3D * 3; i++) {
      posArray[i] = (Math.random() - 0.5) * 4;
    }
    particlesGeo.setAttribute('position', new THREE.BufferAttribute(posArray, 3));

    const particlesMat = new THREE.PointsMaterial({
      size: 0.035,
      color: 0x00f2fe,
      transparent: true,
      opacity: 0.8
    });
    const starField = new THREE.Points(particlesGeo, particlesMat);
    scene.add(starField);

    // Interactive Mouse Drag / Parallax Effect
    let mouseX = 0;
    let mouseY = 0;
    let targetX = 0;
    let targetY = 0;

    document.addEventListener('mousemove', (e) => {
      const windowHalfX = window.innerWidth / 2;
      const windowHalfY = window.innerHeight / 2;
      mouseX = (e.clientX - windowHalfX) * 0.001;
      mouseY = (e.clientY - windowHalfY) * 0.001;
    });

    // Dynamic 3D Color Updating based on Theme
    function update3DColors() {
      const isDark = htmlEl.getAttribute('data-theme') === 'dark';
      sphereMat.color.setHex(isDark ? 0x00f2fe : 0x0284c7);
      ringMat1.color.setHex(isDark ? 0x00f2fe : 0x0284c7);
      innerMat.color.setHex(isDark ? 0x7f00ff : 0x7c3aed);
      ringMat2.color.setHex(isDark ? 0x7f00ff : 0x7c3aed);
      particlesMat.color.setHex(isDark ? 0x00f2fe : 0x0284c7);
    }

    if (themeToggle) {
      themeToggle.addEventListener('click', update3DColors);
    }
    update3DColors();

    // 3D Animation Loop
    function render3D() {
      requestAnimationFrame(render3D);

      targetX += (mouseX - targetX) * 0.05;
      targetY += (mouseY - targetY) * 0.05;

      cyberSphere.rotation.y += 0.006;
      cyberSphere.rotation.x += 0.003;

      innerCore.rotation.y -= 0.01;
      innerCore.rotation.z += 0.005;

      techRing1.rotation.z += 0.012;
      techRing2.rotation.z -= 0.008;

      starField.rotation.y += 0.001;

      // Parallax inclination based on mouse move
      scene.rotation.y = targetX * 1.2;
      scene.rotation.x = targetY * 1.2;

      renderer.render(scene, camera);
    }

    render3D();
  }

  // 5. Project Showcase Filtering
  const filterBtns = document.querySelectorAll('.filter-btn');

  filterBtns.forEach((btn) => {
    btn.addEventListener('click', () => {
      filterBtns.forEach((b) => b.classList.remove('active'));
      btn.classList.add('active');

      const filter = btn.getAttribute('data-filter');
      const currentProjectCards = document.querySelectorAll('.project-card');

      currentProjectCards.forEach((card) => {
        const cat = (card.getAttribute('data-category') || '').toLowerCase();
        
        let match = false;
        if (filter === 'all') {
            match = true;
        } else if (filter === 'ai' && (cat === 'ai' || cat === 'iot')) {
            match = true;
        } else if (filter === 'web' && (cat === 'web' || cat === 'app')) {
            match = true;
        } else if (filter === 'network' && (cat === 'network' || cat === 'other')) {
            match = true;
        } else if (cat === filter) {
            match = true;
        }

        if (match) {
          card.style.display = 'flex';
          card.style.animation = 'fadeIn 0.4s forwards';
        } else {
          card.style.display = 'none';
        }
      });
    });
  });

  // 6. Statistics Counter Animation
  const statNumbers = document.querySelectorAll('.stat-number');
  let animated = false;

  function runCounters() {
    statNumbers.forEach((el) => {
      const target = parseInt(el.getAttribute('data-target') || '0', 10);
      const suffix = el.getAttribute('data-suffix') || '';
      let count = 0;
      const step = Math.max(1, Math.ceil(target / 40));

      const interval = setInterval(() => {
        count += step;
        if (count >= target) {
          count = target;
          clearInterval(interval);
        }
        el.textContent = count + suffix;
      }, 30);
    });
  }

  const statsSection = document.querySelector('.stats-grid');
  if (statsSection) {
    const observer = new IntersectionObserver(
      (entries) => {
        if (entries[0].isIntersecting && !animated) {
          animated = true;
          runCounters();
        }
      },
      { threshold: 0.3 }
    );
    observer.observe(statsSection);
  }

  // 7. Contact Form Submission
  const contactForm = document.getElementById('contactForm');
  if (contactForm) {
    contactForm.addEventListener('submit', (e) => {
      e.preventDefault();
      const btn = contactForm.querySelector('button[type="submit"]');
      const inputs = contactForm.querySelectorAll('.form-input, .form-textarea');
      const name = inputs[0].value;
      const email = inputs[1].value;
      const message = inputs[3].value; // The 4th element is the textarea

      if (btn) {
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> กำลังส่ง...';
        btn.disabled = true;

        fetch('http://localhost:8083/contact.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ name, email, message })
        })
        .then(res => res.json())
        .then(data => {
          if (data.success) {
            btn.innerHTML = '<i class="fas fa-check-circle"></i> ส่งข้อมูลเรียบร้อยแล้ว!';
            btn.style.background = 'var(--accent-emerald)';
            btn.style.color = '#fff';

            setTimeout(() => {
              btn.innerHTML = originalText;
              btn.style.background = '';
              btn.style.color = '';
              btn.disabled = false;
              contactForm.reset();
            }, 3000);
          } else {
            alert('เกิดข้อผิดพลาด: ' + data.error);
            btn.innerHTML = originalText;
            btn.disabled = false;
          }
        })
        .catch(err => {
          console.error(err);
          alert('ไม่สามารถเชื่อมต่อเซิร์ฟเวอร์ได้');
          btn.innerHTML = originalText;
          btn.disabled = false;
        });
      }
    });
  }

  // 8. Fetch Data from Backend API (Projects & News)
  const newsContainer = document.getElementById('newsContainer');
  if (newsContainer) {
    fetch('http://localhost:8083/get_news.php')
      .then(res => res.json())
      .then(data => {
        if (data.success && data.data.length > 0) {
          newsContainer.innerHTML = '';
          data.data.forEach(news => {
            const date = new Date(news.created_at).toLocaleDateString('th-TH');
            const card = document.createElement('div');
            card.className = 'glass-card track-card';
            card.innerHTML = `
              <div class="track-icon" style="color: var(--accent-purple);">
                <i class="fas fa-bullhorn"></i>
              </div>
              <div class="track-content">
                <h3 style="font-size: 1.2rem; margin-bottom: 0.5rem;">${news.title}</h3>
                <p style="margin-bottom: 1rem; color: var(--text-muted);">${news.content}</p>
                <span class="tag"><i class="far fa-clock"></i> ${date}</span>
              </div>
            `;
            newsContainer.appendChild(card);
          });
        } else {
          newsContainer.innerHTML = '<div style="grid-column: 1 / -1; text-align: center; color: var(--text-muted); padding: 2rem;">ไม่มีข่าวสารในขณะนี้</div>';
        }
      })
      .catch(err => console.error('Error fetching news:', err));
  }

  const showcaseGrid = document.querySelector('.showcase-grid');
  if (showcaseGrid) {
    fetch('http://localhost:8083/get_projects.php')
      .then(res => res.json())
      .then(data => {
        if (data.success && data.data.length > 0) {
          showcaseGrid.innerHTML = '';
          data.data.forEach(p => {
            const card = document.createElement('div');
            card.className = 'glass-card project-card';
            card.setAttribute('data-category', p.category);
            card.innerHTML = `
                <div class="project-thumb">
                    <img src="${p.image_path}" class="project-thumb-bg" alt="${p.title}" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                <div class="project-info">
                    <span class="project-cat" style="color: var(--accent-cyan); text-transform: uppercase;">${p.category}</span>
                    <h3 class="project-title">${p.title}</h3>
                    <p class="project-desc">${p.description}</p>
                </div>
            `;
            showcaseGrid.appendChild(card);
          });
          
          // Re-trigger active filter
          const activeFilter = document.querySelector('.filter-btn.active');
          if(activeFilter) { activeFilter.click(); }
        }
      })
      .catch(err => console.error('Error fetching projects:', err));
  }

  // 9. Check User Session for Dynamic Navbar
  const authContainer = document.getElementById('authContainer');
  if (authContainer) {
    fetch('http://localhost:8081/check_session.php', { credentials: 'include' })
      .then(res => res.json())
      .then(data => {
        if (data.logged_in) {
          const user = data.user;
          let dashboardLink = '';
          if (user.role === 'admin') {
              dashboardLink = `<a href="http://localhost:8081/index.php" style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 1.2rem; color: var(--text-color); text-decoration: none; font-size: 0.95rem; transition: all 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.05)'" onmouseout="this.style.background='transparent'"><i class="fas fa-cog"></i> จัดการระบบ</a>`;
          }
          authContainer.innerHTML = `
            <div style="position: relative;" class="user-dropdown-container">
                <button id="userDropdownBtn" style="background: none; border: 1px solid rgba(255,255,255,0.1); border-radius: 50px; color: var(--text-color); font-size: 0.95rem; font-weight: 500; display: inline-flex; align-items: center; gap: 0.5rem; cursor: pointer; padding: 0.4rem 1.2rem; white-space: nowrap; transition: all 0.3s ease;" onmouseover="this.style.background='rgba(255,255,255,0.05)'" onmouseout="this.style.background='transparent'">
                    <i class="fas fa-user-circle"></i> ${user.username} <i class="fas fa-chevron-down" style="font-size: 0.8em; margin-left: 0.2rem;"></i>
                </button>
                <div id="userDropdownMenu" style="display: none; position: absolute; right: 0; top: 120%; min-width: 180px; background: #0f172a; border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.5); z-index: 1000; padding: 0.5rem 0;">
                    ${dashboardLink}
                    <a href="http://localhost:8081/logout.php" style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 1.2rem; color: #ef4444; text-decoration: none; font-size: 0.95rem; transition: all 0.2s;" onmouseover="this.style.background='rgba(239, 68, 68, 0.1)'" onmouseout="this.style.background='transparent'">
                        <i class="fas fa-sign-out-alt"></i> ออกจากระบบ
                    </a>
                </div>
            </div>
          `;
          
          setTimeout(() => {
              const btn = document.getElementById('userDropdownBtn');
              const menu = document.getElementById('userDropdownMenu');
              if (btn && menu) {
                  btn.addEventListener('click', (e) => {
                      e.stopPropagation();
                      menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
                  });
                  document.addEventListener('click', (e) => {
                      if (!menu.contains(e.target) && !btn.contains(e.target)) {
                          menu.style.display = 'none';
                      }
                  });
              }
          }, 0);
        }
      })
      .catch(err => console.error('Session check failed', err));
  }
});
