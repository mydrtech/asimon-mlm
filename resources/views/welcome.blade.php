<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Asimon Lifestyle | Pure Care Always — MLM Ecosystem by Dr. Tech</title>
    <!-- Google Fonts + Preconnect -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Font Awesome 6 (free) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #ffffff;
            color: #1A2C3E;
            line-height: 1.5;
            scroll-behavior: smooth;
        }

        h1, h2, h3, h4, .logo, .nav-links a, .btn, .stat-number, .plan-name {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* Color system — fresh wellness + premium MLM */
        :root {
            --primary-dark: #0B2B26;
            --primary: #165A4A;
            --primary-light: #228B6F;
            --accent: #E8B86B;
            --accent-dark: #D4A04A;
            --cream: #FEF9F0;
            --gray-bg: #F8FAFC;
            --gray-border: #E2E8F0;
            --text-dark: #1E293B;
            --text-muted: #5A6E7F;
            --white: #ffffff;
            --success: #2E7D64;
        }

        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 32px;
        }

        /* header & navigation — clean & modern */
        .navbar {
            background: rgba(255,255,255,0.96);
            backdrop-filter: blur(10px);
            position: sticky;
            top: 0;
            z-index: 100;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            box-shadow: 0 2px 20px rgba(0,0,0,0.02);
        }

        .nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 32px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .logo h1 {
            font-size: 26px;
            font-weight: 800;
            letter-spacing: -0.02em;
            color: var(--primary-dark);
        }
        .logo span {
            font-size: 12px;
            font-weight: 500;
            color: var(--accent);
            letter-spacing: 1px;
            display: block;
            line-height: 1.2;
        }

        .nav-links {
            display: flex;
            gap: 32px;
            align-items: center;
        }
        .nav-links a {
            text-decoration: none;
            font-weight: 600;
            color: var(--text-dark);
            transition: 0.2s;
            font-size: 15px;
        }
        .nav-links a:hover {
            color: var(--accent-dark);
        }
        .btn-outline {
            border: 1.5px solid var(--primary);
            background: transparent;
            padding: 8px 20px;
            border-radius: 40px;
            font-weight: 700;
            transition: 0.25s;
        }
        .btn-outline:hover {
            background: var(--primary);
            color: white !important;
            border-color: var(--primary);
        }
        .btn-solid {
            background: var(--primary);
            color: white;
            padding: 10px 28px;
            border-radius: 40px;
            font-weight: 700;
            border: none;
            transition: 0.2s;
            box-shadow: 0 4px 10px rgba(22,90,74,0.2);
        }
        .btn-solid:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
        }
        .btn-accent {
            background: var(--accent);
            color: var(--primary-dark);
            border: none;
            font-weight: 800;
            padding: 14px 36px;
            border-radius: 50px;
            font-size: 1rem;
            transition: all 0.2s ease;
            box-shadow: 0 6px 14px rgba(232,184,107,0.3);
        }
        .btn-accent:hover {
            background: var(--accent-dark);
            transform: scale(1.02);
        }

        /* hero section — inspired by wellness & opportunity */
        .hero {
            padding: 70px 0 60px;
            background: linear-gradient(135deg, var(--cream) 0%, #ffffff 85%);
        }
        .hero-grid {
            display: flex;
            align-items: center;
            gap: 50px;
            flex-wrap: wrap;
        }
        .hero-content {
            flex: 1.2;
        }
        .hero-badge {
            display: inline-block;
            background: rgba(232,184,107,0.15);
            padding: 6px 18px;
            border-radius: 40px;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--accent-dark);
            margin-bottom: 24px;
        }
        .hero-content h1 {
            font-size: 52px;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 20px;
            letter-spacing: -0.02em;
            color: var(--primary-dark);
        }
        .hero-highlight {
            color: var(--accent-dark);
        }
        .hero-content p {
            font-size: 18px;
            color: var(--text-muted);
            max-width: 90%;
            margin-bottom: 32px;
        }
        .hero-stats {
            display: flex;
            gap: 36px;
            margin-top: 40px;
        }
        .stat-item h3 {
            font-size: 32px;
            font-weight: 800;
            color: var(--primary);
        }
        .stat-item p {
            font-size: 14px;
            color: var(--text-muted);
            margin: 0;
        }
        .hero-image {
            flex: 0.9;
            background: radial-gradient(circle at 30% 20%, rgba(22,90,74,0.05), transparent);
            border-radius: 40px;
            text-align: center;
        }
        .hero-image svg {
            max-width: 100%;
            filter: drop-shadow(0 12px 20px rgba(0,0,0,0.05));
        }

        /* trust bar with pure care message */
        .trust-bar {
            background: var(--gray-bg);
            padding: 24px 0;
            text-align: center;
            border-top: 1px solid var(--gray-border);
            border-bottom: 1px solid var(--gray-border);
        }
        .trust-logos {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 28px;
        }
        .trust-logos span {
            font-weight: 600;
            color: var(--text-muted);
            font-size: 14px;
            letter-spacing: 0.3px;
        }
        .trust-logos i {
            margin-right: 8px;
            color: var(--accent);
        }

        /* features grid — health & mlm fusion */
        .section {
            padding: 80px 0;
        }
        .section-title {
            text-align: center;
            font-size: 38px;
            font-weight: 800;
            margin-bottom: 16px;
            color: var(--primary-dark);
        }
        .section-sub {
            text-align: center;
            color: var(--text-muted);
            max-width: 680px;
            margin: 0 auto 56px auto;
            font-size: 18px;
        }
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 36px;
        }
        .feature-card {
            background: white;
            border-radius: 28px;
            padding: 32px 24px;
            box-shadow: 0 12px 28px -8px rgba(0,0,0,0.05);
            transition: all 0.25s;
            border: 1px solid #EDF2F7;
        }
        .feature-card:hover {
            transform: translateY(-6px);
            border-color: var(--accent);
            box-shadow: 0 24px 36px -12px rgba(22,90,74,0.12);
        }
        .feature-icon {
            font-size: 44px;
            color: var(--accent);
            margin-bottom: 24px;
        }
        .feature-card h3 {
            font-size: 22px;
            margin-bottom: 12px;
        }

        /* compensation plan — transparent mlm */
        .plan-preview {
            background: var(--cream);
            border-radius: 48px;
            margin: 30px 0;
            padding: 48px 32px;
        }
        .plan-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            justify-content: center;
        }
        .plan-card {
            background: white;
            flex: 1;
            min-width: 210px;
            padding: 28px 20px;
            text-align: center;
            border-radius: 32px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.02);
            border: 1px solid #E9EDF2;
            transition: all 0.2s;
        }
        .plan-card.special {
            border-top: 4px solid var(--accent);
            background: linear-gradient(to bottom, #FFFFFF, #FFFCF5);
        }
        .plan-name {
            font-weight: 800;
            font-size: 24px;
            margin-bottom: 12px;
        }
        .plan-commission {
            font-size: 36px;
            font-weight: 800;
            color: var(--primary);
            margin: 16px 0;
        }

        /* Dr. Tech signature section */
        .drtech-section {
            background: var(--primary-dark);
            color: white;
            border-radius: 48px;
            margin: 50px 0;
            overflow: hidden;
        }
        .drtech-inner {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 40px;
        }
        .drtech-text {
            flex: 1;
            padding: 48px 40px;
        }
        .drtech-text h2 {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 20px;
        }
        .drtech-quote {
            font-style: italic;
            border-left: 4px solid var(--accent);
            padding-left: 20px;
            margin: 20px 0;
            font-weight: 500;
        }

        /* CTA + footer */
        .cta {
            text-align: center;
            background: linear-gradient(115deg, #FDF8F0, #ffffff);
            border-radius: 48px;
            padding: 60px 32px;
            margin: 40px 0 60px;
        }
        footer {
            background: #0B2B26;
            color: #CBD5E1;
            padding: 56px 0 32px;
            margin-top: 40px;
        }
        .footer-grid {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 40px;
        }
        .footer-col h4 {
            color: white;
            margin-bottom: 18px;
        }
        .footer-col a {
            display: block;
            color: #94A3B8;
            text-decoration: none;
            margin: 10px 0;
            font-size: 14px;
        }
        .copyright {
            text-align: center;
            padding-top: 48px;
            font-size: 13px;
            border-top: 1px solid #1E4A40;
            margin-top: 32px;
        }
        @media (max-width: 900px) {
            .hero-content h1 { font-size: 40px; }
            .nav-container { flex-direction: column; gap: 16px; }
            .container { padding: 0 24px; }
        }
    </style>
</head>
<body>

<header class="navbar">
    <div class="nav-container">
        <div class="logo">
            <h1>ASIMON</h1>
            <span>Pure Care Always · by Dr. Tech</span>
        </div>
        <div class="nav-links">
            <a href="#">Home</a>
            <a href="#">Wellness</a>
            <a href="#">Opportunity</a>
            <a href="#">Community</a>
            <a href="#" class="btn-outline">Login</a>
            <a href="#" class="btn-solid">Register →</a>
        </div>
    </div>
</header>

<main>
    <!-- Hero Section with "Pure Care Always" spirit -->
    <section class="hero">
        <div class="container hero-grid">
            <div class="hero-content">
                <div class="hero-badge"><i class="fas fa-leaf"></i> Pure Care Always · Official Launch</div>
                <h1>Elevate Your Life & <span class="hero-highlight">Earn with Purpose</span></h1>
                <p>Asimon Lifestyle blends premium wellness products with a next-gen MLM platform. Join Dr. Tech’s movement — transparency, health, and high-performance rewards.</p>
                <div style="display: flex; gap: 18px; flex-wrap: wrap;">
                    <a href="#" class="btn-accent">Start Your Journey <i class="fas fa-arrow-right"></i></a>
                    <a href="#" style="display: inline-flex; align-items: center; gap: 8px; font-weight: 600;">Explore products <i class="fas fa-seedling"></i></a>
                </div>
                <div class="hero-stats">
                    <div class="stat-item"><h3>45K+</h3><p>Active Partners</p></div>
                    <div class="stat-item"><h3>$28M</h3><p>Commissions Paid</p></div>
                    <div class="stat-item"><h3>30+</h3><p>Countries</p></div>
                </div>
            </div>
            <div class="hero-image">
                <svg viewBox="0 0 400 350" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="200" cy="170" r="130" fill="url(#gradWellness)" fill-opacity="0.2" stroke="#E8B86B" stroke-width="1.5" stroke-dasharray="5 5"/>
                    <path d="M200 90 L240 140 L300 150 L260 200 L275 270 L200 230 L125 270 L140 200 L100 150 L160 140 L200 90Z" fill="#165A4A" fill-opacity="0.15" stroke="#165A4A" stroke-width="2"/>
                    <text x="200" y="185" text-anchor="middle" fill="#0B2B26" font-weight="800" font-size="26" font-family="'Plus Jakarta Sans'">ASIMON</text>
                    <text x="200" y="215" text-anchor="middle" fill="#E8B86B" font-weight="600" font-size="12">Pure Care Always</text>
                    <circle cx="200" cy="170" r="40" fill="#E8B86B" fill-opacity="0.1" stroke="#E8B86B" stroke-width="1"/>
                    <defs><linearGradient id="gradWellness" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#E8B86B"/><stop offset="100%" stop-color="#165A4A"/></linearGradient></defs>
                </svg>
            </div>
        </div>
    </section>

    <!-- Trust Bar - Pure Care Always commitment -->
    <div class="trust-bar">
        <div class="container trust-logos">
            <span><i class="fas fa-flask"></i> Science-Backed Wellness</span>
            <span><i class="fas fa-hand-holding-heart"></i> Pure Care Always</span>
            <span><i class="fas fa-chart-line"></i> Smart MLM Technology</span>
            <span><i class="fas fa-shield-alt"></i> Audited Commissions</span>
            <span><i class="fas fa-globe"></i> Global Community</span>
        </div>
    </div>

    <!-- Features: Health + MLM -->
    <div class="container section">
        <h2 class="section-title">Wellness meets wealth creation</h2>
        <div class="section-sub">Asimon Lifestyle provides premium natural products and a revolutionary compensation plan designed by Dr. Tech.</div>
        <div class="features-grid">
            <div class="feature-card"><div class="feature-icon"><i class="fas fa-spa"></i></div><h3>Pure Care Products</h3><p>Organic, clinically tested health supplements & self-care essentials. "Pure Care Always" promise.</p></div>
            <div class="feature-card"><div class="feature-icon"><i class="fas fa-coins"></i></div><h3>High-Yield Plan</h3><p>Unilevel + binary hybrid with fast-start bonuses, matching pools, and leadership incentives.</p></div>
            <div class="feature-card"><div class="feature-icon"><i class="fas fa-chalkboard-user"></i></div><h3>Dr. Tech Academy</h3><p>World-class training, AI-powered recruitment tools, and live mentorship to scale your team.</p></div>
            <div class="feature-card"><div class="feature-icon"><i class="fas fa-rocket"></i></div><h3>Next-Gen Dashboard</h3><p>Real-time analytics, automated payouts, and mobile-first interface — built for leaders.</p></div>
        </div>
    </div>

    <!-- Compensation plan preview (MLM core) -->
    <div class="container">
        <div class="plan-preview">
            <h2 class="section-title" style="font-size: 32px;">📈 Performance-driven rewards</h2>
            <div class="section-sub">Transparent, lucrative, and built for long-term growth — the Asimon compensation architecture.</div>
            <div class="plan-grid">
                <div class="plan-card"><div class="plan-name">Wellness Advocate</div><div class="plan-commission">18%</div><div class="plan-feature">Personal sales + retail profit</div></div>
                <div class="plan-card special"><div class="plan-name">Elite Partner</div><div class="plan-commission">28%</div><div class="plan-feature">Team bonus + infinity pool</div><i class="fas fa-star" style="color:#E8B86B;"></i></div>
                <div class="plan-card"><div class="plan-name">Director</div><div class="plan-commission">35%</div><div class="plan-feature">Global leadership pool + car fund</div></div>
                <div class="plan-card"><div class="plan-name">Crown Ambassador</div><div class="plan-commission">42%</div><div class="plan-feature">Equity + luxury retreats</div></div>
            </div>
            <div style="text-align: center; margin-top: 36px;"><a href="#" class="btn-solid" style="background: var(--accent); color:#0B2B26;">Full compensation breakdown →</a></div>
        </div>
    </div>

    <!-- Dr. Tech Visionary Section (signature) -->
    <div class="container">
        <div class="drtech-section">
            <div class="drtech-inner">
                <div class="drtech-text">
                    <h2>Engineered by Dr. Tech <i class="fas fa-microchip"></i></h2>
                    <p>With 12+ years in network marketing infrastructure, Dr. Tech created Asimon Lifestyle to merge "Pure Care Always" wellness with ethical, high-tech MLM. Every commission is verifiable, every product is premium.</p>
                    <div class="drtech-quote">"We are redefining direct sales — combining science-backed wellness and blockchain transparency. Asimon is not just an opportunity; it's a movement." — Dr. Tech, Founder</div>
                    <div style="margin-top: 28px;"><a href="#" style="color: #E8B86B; font-weight: 600;">Meet the architect →</a></div>
                </div>
                <div class="drtech-image" style="flex:0.8; background: #1E5A4A; margin:30px; border-radius:32px; display:flex; justify-content:center; align-items:center; min-height:200px;">
                    <i class="fas fa-user-md" style="font-size: 80px; color: rgba(232,184,107,0.4);"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Testimonials & community -->
    <div class="container section">
        <h2 class="section-title">Real stories. Real impact.</h2>
        <div class="section-sub">Thousands are transforming their health and wealth with Asimon.</div>
        <div style="display: flex; flex-wrap: wrap; gap: 32px; justify-content: center;">
            <div style="background: #F8FAFC; padding: 28px; border-radius: 32px; max-width: 320px;">
                <i class="fas fa-quote-left" style="color: #E8B86B; font-size: 28px;"></i>
                <p style="margin: 16px 0;">"The pure care products changed my family's health, and the MLM plan gave me financial freedom. Dr. Tech delivers on every promise."</p>
                <h4>— Linda M., Diamond Director</h4>
            </div>
            <div style="background: #F8FAFC; padding: 28px; border-radius: 32px; max-width: 320px;">
                <i class="fas fa-quote-left" style="color: #E8B86B; font-size: 28px;"></i>
                <p style="margin: 16px 0;">"Best decision I ever made. The training academy and support from Dr. Tech is unmatched. 6-figure earner in 9 months."</p>
                <h4>— Derrick O., Regional VP</h4>
            </div>
            <div style="background: #F8FAFC; padding: 28px; border-radius: 32px; max-width: 320px;">
                <i class="fas fa-quote-left" style="color: #E8B86B; font-size: 28px;"></i>
                <p style="margin: 16px 0;">"Transparent, ethical, and high-energy community. Asimon Lifestyle is the future of network marketing."</p>
                <h4>— Priya K., Top Recruiter</h4>
            </div>
        </div>
    </div>

    <!-- Call to Action -->
    <div class="container">
        <div class="cta">
            <h2>Join the Asimon movement today</h2>
            <p style="font-size: 18px; margin-top: 16px;">Pure Care Always. Unlock your potential with Dr. Tech's revolutionary ecosystem.</p>
            <div style="margin-top: 32px;">
                <a href="#" class="btn-accent" style="background: #165A4A; color: white;">Register as a partner →</a>
                <a href="#" style="margin-left: 20px; font-weight: 600;">Request a product catalog</a>
            </div>
        </div>
    </div>
</main>

<footer>
    <div class="container">
        <div class="footer-grid">
            <div class="footer-col">
                <h4>ASIMON LIFESTYLE</h4>
                <p>Pure Care Always · Health & Wellness MLM<br>Powered by Dr. Tech Innovations</p>
                <div style="margin-top: 20px;"><i class="fab fa-instagram"></i> <i class="fab fa-facebook"></i> <i class="fab fa-youtube"></i> <i class="fab fa-linkedin"></i></div>
            </div>
            <div class="footer-col"><h4>Company</h4><a href="#">About Dr. Tech</a><a href="#">Wellness Mission</a><a href="#">Compliance</a><a href="#">Press</a></div>
            <div class="footer-col"><h4>Resources</h4><a href="#">Compensation Plan</a><a href="#">Product Guide</a><a href="#">Training Portal</a><a href="#">Support</a></div>
            <div class="footer-col"><h4>Legal</h4><a href="#">Privacy Policy</a><a href="#">Terms of Use</a><a href="#">Disclaimer</a></div>
        </div>
        <div class="copyright">© 2026 Asimon Lifestyle — Pure Care Always. Built by Dr. Tech. All rights reserved. Empowering wellness & financial independence.</div>
    </div>
</footer>
<script>
    // smooth scroll for any anchor
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if(href && href !== "#" && href !== "#!" && href.startsWith("#")){
                e.preventDefault();
                const target = document.querySelector(href);
                if(target) target.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });
</script>
</body>
</html>