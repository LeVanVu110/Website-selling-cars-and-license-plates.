<footer id="footer" class="relative bg-[#050505] pt-20 pb-10 overflow-hidden border-t border-gold-bottom">
    <div class="absolute inset-0 opacity-5 pointer-events-none" 
         style="background-image: url('https://www.transparenttextures.com/patterns/black-linen.png');"></div>

    <div class="container mx-auto px-6 md:px-12 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-16">
            
            <div class="footer-col" id="col-identity">
                <h2 class="font-cinzel text-2xl gold-text mb-4">LUXURY PLATE</h2>
                <p class="font-playfair italic text-gray-400 mb-6 text-sm">"Nâng tầm giá trị, khẳng định vị thế"</p>
                <div class="space-y-3 text-gray-500 text-xs tracking-widest leading-6">
                    <p><i class="ri-map-pin-2-line mr-2 text-[#bf953f]"></i> Tòa nhà Kim Cương, Quận 1, TP. HCM</p>
                    <p><i class="ri-phone-line mr-2 text-[#bf953f]"></i> 1900 8888 99</p>
                    <p><i class="ri-shield-check-line mr-2 text-[#bf953f]"></i> Đặc quyền bảo mật thông tin 100%</p>
                </div>
            </div>

            <div class="footer-col">
                <div class="flex justify-between items-center md:block cursor-pointer md:cursor-default accordion-header">
                    <h3 class="text-[#bf953f] font-bold text-xs tracking-[0.2em] mb-6 uppercase">The Vault</h3>
                    <i class="ri-add-line text-[#bf953f] md:hidden transition-transform duration-300"></i>
                </div>
                <ul class="space-y-4 overflow-hidden transition-all duration-500 max-h-0 md:max-h-full accordion-content">
                    <li><a href="#" class="vault-link text-gray-400 text-xs hover:text-white transition-all duration-300">Bộ sưu tập Ngũ Quý</a></li>
                    <li><a href="#" class="vault-link text-gray-400 text-xs hover:text-white transition-all duration-300">Biển số theo yêu cầu</a></li>
                    <li><a href="#" class="vault-link text-gray-400 text-xs hover:text-white transition-all duration-300">Ký gửi nhanh</a></li>
                    <li><a href="#" class="vault-link text-gray-400 text-xs hover:text-white transition-all duration-300">Kiểm tra phong thủy</a></li>
                </ul>
            </div>

            <div class="footer-col" id="col-insider">
                <h3 class="text-[#bf953f] font-bold text-xs tracking-[0.2em] mb-6 uppercase">The Insider</h3>
                <p class="text-gray-500 text-xs mb-6">Đăng ký để nhận thông tin về những siêu phẩm vừa cập bến.</p>
                <div class="relative border-b border-[#bf953f]/30 py-2 focus-within:border-[#bf953f] transition-all">
                    <input type="email" placeholder="Email thượng lưu..." 
                           class="bg-transparent w-full outline-none text-white text-sm placeholder:text-gray-700">
                    <button class="absolute right-0 top-1/2 -translate-y-1/2 text-[#bf953f] hover:scale-125 transition-transform">
                        <i class="ri-arrow-right-line text-xl"></i>
                    </button>
                </div>
                
                <div class="mt-8">
                    <p class="text-[10px] text-gray-600 uppercase tracking-widest mb-4">Kết nối với cộng đồng thượng lưu</p>
                    <div class="flex gap-4">
                        <a href="#" class="social-icon w-8 h-8 rounded-full border border-gold/20 flex items-center justify-center text-[#bf953f] hover:bg-[#bf953f] hover:text-black transition-all">
                            <i class="ri-facebook-fill"></i>
                        </a>
                        <a href="#" class="social-icon w-8 h-8 rounded-full border border-gold/20 flex items-center justify-center text-[#bf953f] hover:bg-[#bf953f] hover:text-black transition-all">
                            <i class="ri-instagram-line"></i>
                        </a>
                        <a href="#" class="social-icon w-8 h-8 rounded-full border border-gold/20 flex items-center justify-center text-[#bf953f] hover:bg-[#bf953f] hover:text-black transition-all">
                            <i class="ri-youtube-fill"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-8 border-t border-white/5 flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="text-[9px] text-white/20 hover:text-white/40 transition-colors uppercase tracking-widest text-center md:text-left">
                Giấy phép số: 0316XXXXXX | MST: 0102XXXXXX | Cấp bởi Sở KH&ĐT TP.HCM
                <br>© 2026 LUXURY PLATE. All Rights Reserved.
            </div>
            <div class="flex items-center gap-4 opacity-30 grayscale hover:opacity-100 hover:grayscale-0 transition-all duration-700">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/d/d5/Logo_bo_cong_thuong.svg/1024px-Logo_bo_cong_thuong.svg.png" 
                     alt="Bộ công thương" class="h-8">
            </div>
        </div>
    </div>
</footer>

<style>
    /* Bổ sung Style cho Footer */
    .vault-link:hover {
        text-shadow: 0 0 8px rgba(191, 149, 63, 0.8);
        padding-left: 10px;
    }
    
    .gold-text {
        background: linear-gradient(90deg, #bf953f, #fcf6ba, #b38728);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .border-gold-bottom {
        border-image: linear-gradient(90deg, transparent, #bf953f, transparent) 1;
    }
</style>

<script>
    // 1. GSAP: Hiệu ứng Logo sáng rực và nảy nhẹ khi cuộn tới cuối
    gsap.from("#col-identity", {
        scrollTrigger: {
            trigger: "#footer",
            start: "top bottom",
            toggleActions: "play none none none"
        },
        y: 50,
        opacity: 0,
        duration: 1.5,
        ease: "expo.out"
    });

    // 2. Mobile Accordion Logic
    const accordionHeader = document.querySelector('.accordion-header');
    const accordionContent = document.querySelector('.accordion-content');
    const accordionIcon = document.querySelector('.accordion-header i');

    accordionHeader.addEventListener('click', () => {
        if (window.innerWidth < 768) {
            const isOpen = accordionContent.style.maxHeight !== '0px' && accordionContent.style.maxHeight !== '';
            accordionContent.style.maxHeight = isOpen ? '0px' : '500px';
            accordionIcon.style.transform = isOpen ? 'rotate(0deg)' : 'rotate(45deg)';
        }
    });

    // 3. Hiệu ứng Hover tỏa hào quang cho các link
    document.querySelectorAll('.vault-link').forEach(link => {
        link.addEventListener('mouseenter', () => {
            gsap.to(link, { x: 10, duration: 0.3, ease: "power2.out" });
        });
        link.addEventListener('mouseleave', () => {
            gsap.to(link, { x: 0, duration: 0.3, ease: "power2.out" });
        });
    });
</script>