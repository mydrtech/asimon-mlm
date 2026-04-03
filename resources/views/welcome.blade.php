<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Asimon | Next-Gen MLM Ecosystem by Dr. Tech</title>
    <!-- Google Fonts + Preconnect -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,600;14..32,700;14..32,800&family=Syne:wght@400;500;600;700;800&display=swap" rel="stylesheet">
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
            color: #111827;
            line-height: 1.5;
            scroll-behavior: smooth;
        }

        h1, h2, h3, h4, .logo, .nav-links a, .btn, .stat-number, .plan-name {
            font-family: 'Syne', sans-serif;
        }

        /* gradient & accent */
        :root {
            --primary: #0A2647;
            --primary-dark: #051a2f;
            --accent: #D4AF37;
            --accent-glow: #e4c462;
            --gray-bg: #F9FAFB;
            --gray-border: #E5E7EB;
            --text-light: #6B7280;
        }

        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 32px;
        }

        /* header & nav */
        .navbar {
            background: rgba(255,255,255,0.96);
            backdrop-filter: blur(12px);
            position: sticky;
            top: 0;
            z-index: 100;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            box-shadow: 0 4px 20px rgba(0,0,0,0.02);
        }

        .nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 18px 32px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .logo h1 {
            font-size: 28px;
            font-weight: 800;
            letter-spacing: -0.02em;
            background: linear-gradient(135deg, #0A2647 0%, #1E3A5F 100%);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
        }
        .logo span {
            font-size: 14px;
            font-weight: 500;
            color: var(--accent);
            background: none;
            -webkit-background-clip: unset;
            background-clip: unset;
            display: block;
            letter-spacing: 1px;
        }

        .nav-links {
            display: flex;
            gap: 36px;
            align-items: center;
        }
        .nav-links a {
            text-decoration: none;
            font-weight: 600;
            color: #1F2937;
            transition: 0.2s;
            font-size: 16px;
        }
        .nav-links a:hover {
            color: var(--accent);
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
            box-shadow: 0 4px 8px rgba(10,38,71,0.12);
        }
        .btn-solid:hover {
            background: #0D3559;
            transform: translateY(-2px);
            box-shadow: 0 12px 20px -8px rgba(10,38,71,0.3);
        }
        .btn-accent {
            background: var(--accent);
            color: #0A2647;
            border: none;
            font-weight: 800;
            padding: 14px 36px;
            border-radius: 50px;
            font-size: 1rem;
            transition: all 0.2s ease;
            box-shadow: 0 6px 14px rgba(212,175,55,0.25);
        }
        .btn-accent:hover {
            background: #e2bc42;
            transform: scale(1.02);
            box-shadow: 0 10px 20px rgba(212,175,55,0.35);
        }

        /* hero */
        .hero {
            padding: 80px 0 70px;
            background: linear-gradient(135deg, #FEF9F0 0%, #ffffff 80%);
        }
        .hero-grid {
            display: flex;
            align-items: center;
            gap: 48px;
            flex-wrap: wrap;
        }
        .hero-content {
            flex: 1.2;
        }
        .hero-badge {
            display: inline-block;
            background: rgba(212,175,55,0.12);
            padding: 6px 16px;
            border-radius: 40px;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--accent);
            margin-bottom: 24px;
            letter-spacing: 0.3px;
        }
        .hero-content h1 {
            font-size: 54px;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 24px;
            letter-spacing: -0.02em;
            background: linear-gradient(145deg, #0A2647, #2B4F6E);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
        }
        .hero-content p {
            font-size: 18px;
            color: #4B5563;
            max-width: 90%;
            margin-bottom: 32px;
        }
        .hero-stats {
            display: flex;
            gap: 32px;
            margin-top: 40px;
        }
        .stat-item h3 {
            font-size: 32px;
            font-weight: 800;
            color: #0A2647;
        }
        .stat-item p {
            font-size: 14px;
            color: var(--text-light);
            margin: 0;
        }
        .hero-image {
            flex: 0.9;
            background: radial-gradient(circle at 30% 20%, rgba(212,175,55,0.08), transparent);
            border-radius: 40px;
            text-align: center;
        }
        .hero-image img {
            max-width: 100%;
            filter: drop-shadow(0 20px 25px -12px rgba(0,0,0,0.15));
        }

        /* trust / partners */
        .trust-bar {
            background: #F3F4F6;
            padding: 24px 0;
            text-align: center;
        }
        .trust-logos {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 32px;
            opacity: 0.7;
        }
        .trust-logos span {
            font-weight: 600;
            color: #4B5563;
            font-size: 15px;
            letter-spacing: 1px;
        }

        /* features section */
        .section {
            padding: 80px 0;
        }
        .section-title {
            text-align: center;
            font-size: 38px;
            font-weight: 800;
            margin-bottom: 16px;
        }
        .section-sub {
            text-align: center;
            color: #6B7280;
            max-width: 640px;
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
            border: 1px solid #F0F2F5;
        }
        .feature-card:hover {
            transform: translateY(-6px);
            border-color: var(--accent);
            box-shadow: 0 24px 36px -12px rgba(10,38,71,0.12);
        }
        .feature-icon {
            font-size: 42px;
            color: var(--accent);
            margin-bottom: 24px;
        }
        .feature-card h3 {
            font-size: 22px;
            margin-bottom: 12px;
        }

        /* compensation plan preview */
        .plan-preview {
            background: var(--gray-bg);
            border-radius: 60px;
            margin: 40px 0;
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
            min-width: 220px;
            padding: 28px 20px;
            text-align: center;
            border-radius: 32px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.02);
            border: 1px solid #EDF2F7;
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
        .plan-feature {
            font-size: 14px;
            color: #4B5563;
            margin: 12px 0;
        }

        /* Dr Tech section */
        .drtech-section {
            background: #0A2647;
            color: white;
            border-radius: 48px;
            margin: 40px 0;
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
            font-size: 38px;
            font-weight: 700;
            margin-bottom: 20px;
        }
        .drtech-text p {
            color: #CFDDEB;
            font-size: 17px;
            margin-bottom: 28px;
        }
        .drtech-quote {
            font-style: italic;
            border-left: 4px solid var(--accent);
            padding-left: 20px;
            font-weight: 500;
        }
        .drtech-image {
            flex: 0.8;
            background: #1E3A5F;
            min-height: 280px;
            border-radius: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 30px;
        }
        .drtech-image i {
            font-size: 120px;
            color: rgba(212,175,55,0.25);
        }

        /* CTA */
        .cta {
            text-align: center;
            background: linear-gradient(125deg, #FEF9F0, #ffffff);
            border-radius: 48px;
            padding: 60px 32px;
            margin: 40px 0 60px;
        }
        .cta h2 {
            font-size: 40px;
            font-weight: 800;
        }

        /* footer */
        footer {
            background: #0A1C2E;
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
            font-weight: 700;
        }
        .footer-col a {
            display: block;
            color: #94A3B8;
            text-decoration: none;
            margin: 10px 0;
            font-size: 14px;
        }
        .social-icons i {
            font-size: 20px;
            margin-right: 18px;
            transition: 0.2s;
        }
        .copyright {
            text-align: center;
            padding-top: 48px;
            font-size: 13px;
            border-top: 1px solid #1E2F41;
            margin-top: 32px;
        }

        @media (max-width: 900px) {
            .nav-container {
                flex-direction: column;
                gap: 16px;
            }
            .hero-content h1 {
                font-size: 40px;
            }
            .container {
                padding: 0 24px;
            }
            .hero-stats {
                flex-wrap: wrap;
            }
        }
        @media (max-width: 680px) {
            .nav-links {
                flex-wrap: wrap;
                justify-content: center;
                gap: 20px;
            }
            .section-title {
                font-size: 32px;
            }
        }
        .mlm-badge {
            background: rgba(212,175,55,0.2);
            border-radius: 30px;
            font-weight: 600;
        }
    </style>
</head>
<body>

<header class="navbar">
    <div class="nav-container">
        <div class="logo">
            <h1>ASIMON</h1>
            <span>by Dr. Tech</span>
        </div>
        <div class="nav-links">
            <a href="#">Home</a>
            <a href="#">Opportunity</a>
            <a href="#">Compensation</a>
            <a href="#">Community</a>
            <a href="#" class="btn-outline">Login</a>
            <a href="#" class="btn-solid">Join Asimon →</a>
        </div>
    </div>
</header>

<main>
    <!-- Hero -->
    <section class="hero">
        <div class="container hero-grid">
            <div class="hero-content">
                <div class="hero-badge">
                    <i class="fas fa-crown" style="margin-right: 6px;"></i> Official Launch 2026
                </div>
                <h1>Redefining MLM <br> with Blockchain Precision</h1>
                <p>Asimon by Dr. Tech delivers a next-generation network marketing ecosystem — transparent, high-yield, and globally scalable. Join the future of decentralized wealth creation.</p>
                <div style="display: flex; gap: 18px; flex-wrap: wrap;">
                    <a href="#" class="btn-accent">Start your journey <i class="fas fa-arrow-right"></i></a>
                    <a href="#" style="display: inline-flex; align-items: center; gap: 8px; font-weight: 600;">Watch demo <i class="fas fa-play-circle"></i></a>
                </div>
                <div class="hero-stats">
                    <div class="stat-item"><h3>150K+</h3><p>Active Ambassadors</p></div>
                    <div class="stat-item"><h3>$82M</h3><p>Commissions Paid</p></div>
                    <div class="stat-item"><h3>125+</h3><p>Countries</p></div>
                </div>
            </div>
            <div class="hero-image">
                <!-- abstract modern graphic instead of external image to avoid missing resources -->
                <svg viewBox="0 0 400 380" fill="none" xmlns="http://www.w3.org/2000/svg" style="width:100%; height:auto;">
                    <circle cx="200" cy="180" r="140" fill="url(#grad1)" fill-opacity="0.2" stroke="#D4AF37" stroke-width="1.5" stroke-dasharray="6 6"/>
                    <circle cx="200" cy="180" r="100" fill="#0A2647" fill-opacity="0.05" stroke="#D4AF37" stroke-width="2"/>
                    <path d="M200 80 L240 140 L310 160 L260 210 L270 280 L200 250 L130 280 L140 210 L90 160 L160 140 L200 80Z" fill="#D4AF37" fill-opacity="0.3" stroke="#D4AF37" stroke-width="2"/>
                    <text x="200" y="200" text-anchor="middle" fill="#0A2647" font-weight="800" font-size="28" font-family="Syne">ASIMON</text>
                    <text x="200" y="230" text-anchor="middle" fill="#D4AF37" font-weight="600" font-size="12">by Dr.Tech</text>
                    <defs>
                        <linearGradient id="grad1" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" stop-color="#D4AF37"/>
                            <stop offset="100%" stop-color="#0A2647"/>
                        </linearGradient>
                    </defs>
                </svg>
            </div>
        </div>
    </section>

    <!-- Trust bar -->
    <div class="trust-bar">
        <div class="container trust-logos">
            <span><i class="fas fa-chart-line"></i> Verified Smart Contracts</span>
            <span><i class="fas fa-shield-alt"></i> KYC / AML Ready</span>
            <span><i class="fas fa-globe"></i> Global Payout System</span>
            <span><i class="fas fa-users"></i> AI Matching Bonus</span>
            <span><i class="fas fa-rocket"></i> Dr.Tech Innovation</span>
        </div>
    </div>

    <!-- Core features -->
    <div class="container section">
        <h2 class="section-title">Engineered for modern networkers</h2>
        <div class="section-sub">Asimon combines cutting-edge technology with proven MLM mechanics to maximize your growth.</div>
        <div class="features-grid">
            <div class="feature-card"><div class="feature-icon"><i class="fas fa-link"></i></div><h3>Smart Compensation</h3><p>Dual-team + matrix hybrid with real-time analytics. Unilevel bonuses, leadership pools & more.</p></div>
            <div class="feature-card"><div class="feature-icon"><i class="fas fa-charging-station"></i></div><h3>Instant Wallet</h3><p>Daily settlements, multi-currency support, and low-fee withdrawals. Powered by Dr.Tech secure vault.</p></div>
            <div class="feature-card"><div class="feature-icon"><i class="fas fa-chart-simple"></i></div><h3>AI Cloning System</h3><p>Smart recruitment assistant + automated follow-ups, helping you scale 3x faster.</p></div>
            <div class="feature-card"><div class="feature-icon"><i class="fas fa-gem"></i></div><h3>Elite Rewards</h3><p>Luxury trips, car bonuses, and founder’s circle – real recognition for top leaders.</p></div>
        </div>
    </div>

    <!-- Compensation plan preview -->
    <div class="container plan-preview section" style="padding: 40px 32px;">
        <h2 class="section-title" style="font-size: 34px;">⚡ High-performance Plan</h2>
        <div class="section-sub">Transparent, lucrative, and fully audited — the Asimon compensation architecture.</div>
        <div class="plan-grid">
            <div class="plan-card"><div class="plan-name">Starter</div><div class="plan-commission">18%</div><div class="plan-feature">Personal sales bonus + fast start</div><div class="plan-feature">up to $1.2k weekly cap</div></div>
            <div class="plan-card special"><div class="plan-name">Professional</div><div class="plan-commission">28%</div><div class="plan-feature">Matching bonus + infinity pool</div><div class="plan-feature">unilevel depth 12</div><i class="fas fa-star" style="color:#D4AF37;"></i></div>
            <div class="plan-card"><div class="plan-name">Elite</div><div class="plan-commission">35%</div><div class="plan-feature">Leadership rank bonus</div><div class="plan-feature">global profit share 5%</div></div>
            <div class="plan-card"><div class="plan-name">Ambassador</div><div class="plan-commission">42%</div><div class="plan-feature">Crown director perks</div><div class="plan-feature">+ equity rewards</div></div>
        </div>
        <div style="text-align: center; margin-top: 36px;"><a href="#" class="btn-solid" style="background: var(--accent); color:#0A2647;">View full breakdown →</a></div>
    </div>

    <!-- Dr. Tech Visionary Section -->
    <div class="container">
        <div class="drtech-section">
            <div class="drtech-inner">
                <div class="drtech-text">
                    <h2>Built by Dr. Tech <i class="fas fa-microchip"></i></h2>
                    <p>With over a decade in network marketing infrastructure and blockchain engineering, Dr. Tech envisioned Asimon as a revolutionary ecosystem where trust meets performance. Every line of code is audited, every commission logic is fair.</p>
                    <div class="drtech-quote">"We are not just building an MLM — we are building a movement for financial freedom using AI, Web3, and human-centric design." — Dr. Tech, Founder</div>
                    <div style="margin-top: 28px;"><a href="#" style="color: #D4AF37; font-weight: 600;">Meet the architect →</a></div>
                </div>
                <div class="drtech-image">
                    <i class="fas fa-user-astronaut"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Testimonial / success sneak peek -->
    <div class="container section">
        <h2 class="section-title">Trusted by top earners worldwide</h2>
        <div class="section-sub">Real leaders, real results — the Asimon community is thriving.</div>
        <div style="display: flex; flex-wrap: wrap; gap: 32px; justify-content: center; margin-top: 20px;">
            <div style="background: #F9FAFB; padding: 28px; border-radius: 32px; max-width: 320px;">
                <i class="fas fa-quote-left" style="color: #D4AF37; font-size: 28px;"></i>
                <p style="margin: 16px 0;">"Asimon changed my perspective on MLM. Transparent tracking and weekly payouts that actually match the plan. Dr.Tech team is exceptional."</p>
                <h4 style="margin-top: 12px;">— Anita K., Diamond Director</h4>
            </div>
            <div style="background: #F9FAFB; padding: 28px; border-radius: 32px; max-width: 320px;">
                <i class="fas fa-quote-left" style="color: #D4AF37; font-size: 28px;"></i>
                <p style="margin: 16px 0;">"The AI cloning system gave me a 300% team growth in 2 months. No other platform offers such advanced tools for leaders."</p>
                <h4 style="margin-top: 12px;">— Marcus L., Regional VP</h4>
            </div>
            <div style="background: #F9FAFB; padding: 28px; border-radius: 32px; max-width: 320px;">
                <i class="fas fa-quote-left" style="color: #D4AF37; font-size: 28px;"></i>
                <p style="margin: 16px 0;">"Finally a modern MLM with real-time analytics and mobile-first dashboard. Asimon is the future."</p>
                <h4 style="margin-top: 12px;">— Sophia R., Tech Ambassador</h4>
            </div>
        </div>
    </div>

    <!-- call to action -->
    <div class="container">
        <div class="cta">
            <h2>Ready to claim your Asimon legacy?</h2>
            <p style="font-size: 18px; margin-top: 16px; max-width: 550px; margin-left: auto; margin-right: auto;">Join a global network where innovation meets opportunity. Get your personalized onboarding kit today.</p>
            <div style="margin-top: 32px;">
                <a href="#" class="btn-accent" style="background: #0A2647; color: white; box-shadow: none;">Become an Asimon Partner →</a>
                <a href="#" style="margin-left: 20px; font-weight: 600;">Schedule a live demo</a>
            </div>
        </div>
    </div>
</main>

<footer>
    <div class="container">
        <div class="footer-grid">
            <div class="footer-col">
                <h4>ASIMON</h4>
                <p style="margin-top: 8px;">Next-gen MLM ecosystem<br> by Dr. Tech Innovations.</p>
                <div class="social-icons" style="margin-top: 20px;">
                    <i class="fab fa-linkedin-in"></i>
                    <i class="fab fa-twitter"></i>
                    <i class="fab fa-instagram"></i>
                    <i class="fab fa-youtube"></i>
                </div>
            </div>
            <div class="footer-col">
                <h4>Company</h4>
                <a href="#">About Dr. Tech</a>
                <a href="#">Careers</a>
                <a href="#">Press</a>
                <a href="#">Compliance</a>
            </div>
            <div class="footer-col">
                <h4>Resources</h4>
                <a href="#">Compensation Plan PDF</a>
                <a href="#">Training Academy</a>
                <a href="#">Help Center</a>
                <a href="#">Global Events</a>
            </div>
            <div class="footer-col">
                <h4>Legal</h4>
                <a href="#">Privacy & Terms</a>
                <a href="#">KYC Policy</a>
                <a href="#">Disclaimer</a>
            </div>
        </div>
        <div class="copyright">
            © 2026 Asimon Global — Powered by Dr. Tech. All rights reserved. MLM innovation with integrity.
        </div>
    </div>
</footer>

<!-- subtle scroll behavior -->
<script>
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if(href !== "#" && href !== "" && href !== "#!" && href.startsWith("#")){
                e.preventDefault();
                const target = document.querySelector(href);
                if(target) target.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });
    // optional console greeting
    console.log("Asimon by Dr.Tech — Professional MLM Platform Loaded");
</script>
</body>
</html>