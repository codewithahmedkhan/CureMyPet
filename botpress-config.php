<?php
// BotPress Configuration for CureMyPet

// BotPress Webchat Configuration
$botpress_config = [
    'botId' => 'your-bot-id', // Replace with your actual bot ID from BotPress
    'hostUrl' => 'https://cdn.botpress.cloud/webchat/v3.1', // BotPress Cloud URL v3.1
    'messagingUrl' => 'https://messaging.botpress.cloud', // Messaging URL
    'clientId' => 'your-client-id', // Replace with your client ID
    'webhookId' => 'your-webhook-id', // Replace with your webhook ID
    'lazySocket' => true,
    'themeName' => 'curemypet',
    'frontendVersion' => 'v3.1',
    'showPoweredBy' => false,
    'theme' => 'curemypet',
    'themeColor' => '#e97140' // CureMyPet orange color
];

// Custom styling for the chatbot - SMALLER SIZE
$botpress_styling = [
    'headerBgColor' => '#e97140',
    'headerTextColor' => '#ffffff',
    'botMessageBgColor' => '#f3f4f6',
    'botMessageColor' => '#374151',
    'userMessageBgColor' => '#e97140',
    'userMessageColor' => '#ffffff',
    'textAreaBgColor' => '#ffffff',
    'textAreaColor' => '#374151',
    'botName' => 'CureMyPet Assistant',
    'botAvatarUrl' => 'assets/img/logo/logo.png',
    'containerWidth' => '350px', // Reduced from 400px
    'containerHeight' => '450px' // Reduced from 600px
];

// Predefined intents for pet care
$pet_care_intents = [
    'appointment_booking' => [
        'examples' => [
            'I want to book an appointment',
            'How can I schedule a visit',
            'Book appointment for my pet',
            'I need to see a vet'
        ],
        'response' => 'I can help you book an appointment. Please click here to view our available services: <a href="/services.php">Book Appointment</a>'
    ],
    'emergency' => [
        'examples' => [
            'Emergency',
            'My pet is sick',
            'Urgent help needed',
            'Emergency vet'
        ],
        'response' => 'For emergencies, please call our 24/7 hotline immediately: +880 4664 216. If possible, bring your pet to our clinic right away.'
    ],
    'services' => [
        'examples' => [
            'What services do you offer',
            'Available services',
            'What can you do for my pet',
            'Services list'
        ],
        'response' => 'We offer: Pet Grooming, Vaccination, Health Checkups, Surgery, Dental Care, and Emergency Services. Visit our services page for more details.'
    ],
    'pricing' => [
        'examples' => [
            'How much does it cost',
            'Pricing',
            'Service rates',
            'Consultation fee'
        ],
        'response' => 'Our pricing varies by service. Basic consultation starts at AED 150. For detailed pricing, please visit our services page or contact us directly.'
    ],
    'location' => [
        'examples' => [
            'Where are you located',
            'Address',
            'How to find you',
            'Clinic location'
        ],
        'response' => 'We are located in Dubai, UAE. For exact directions, please visit our contact page or call us at +880 4664 216.'
    ]
];

// Function to initialize BotPress
function initBotPress() {
    global $botpress_config, $botpress_styling;
    ?>
    <script src="https://cdn.botpress.cloud/webchat/v3.1/inject.js" defer></script>
    <script src="https://files.bpcontent.cloud/2025/07/09/08/20250709085817-OAA2RKCA.js" defer></script>
    <script>
        // Wait for scripts to load
        window.addEventListener('load', function() {
            // Custom styling to make the chat smaller
            const style = document.createElement('style');
            style.innerHTML = `
                /* Main chat window sizing */
                .bpw-layout {
                    width: 350px !important;
                    height: 450px !important;
                    max-height: 450px !important;
                    bottom: 80px !important;
                    right: 20px !important;
                }
                
                /* Chat bubble button position */
                .bpw-widget-launcher {
                    bottom: 20px !important;
                    right: 20px !important;
                    width: 55px !important;
                    height: 55px !important;
                    background: #e97140 !important;
                    box-shadow: 0 4px 12px rgba(233, 113, 64, 0.3) !important;
                }
                
                .bpw-widget-launcher:hover {
                    transform: scale(1.05) !important;
                    box-shadow: 0 6px 16px rgba(233, 113, 64, 0.4) !important;
                }
                
                /* Header styling */
                .bpw-header-container {
                    background: linear-gradient(135deg, #e97140 0%, #d6612d 100%) !important;
                    height: 50px !important;
                    padding: 10px 15px !important;
                }
                
                .bpw-header-title {
                    font-size: 16px !important;
                    font-weight: 600 !important;
                }
                
                /* Messages area */
                .bpw-msg-list {
                    max-height: 300px !important;
                    padding: 10px !important;
                }
                
                /* Individual messages */
                .bpw-chat-bubble {
                    font-size: 14px !important;
                    padding: 8px 12px !important;
                    max-width: 80% !important;
                }
                
                .bpw-from-bot .bpw-chat-bubble {
                    background-color: #f3f4f6 !important;
                    color: #374151 !important;
                }
                
                .bpw-from-user .bpw-chat-bubble {
                    background-color: #e97140 !important;
                    color: white !important;
                }
                
                /* Composer/Input area */
                .bpw-composer {
                    height: 45px !important;
                    padding: 8px !important;
                }
                
                .bpw-composer-textarea {
                    font-size: 14px !important;
                    padding: 8px !important;
                    min-height: 32px !important;
                    max-height: 32px !important;
                }
                
                /* Quick replies */
                .bpw-keyboard-quick_reply {
                    font-size: 13px !important;
                    padding: 6px 12px !important;
                    margin: 3px !important;
                    background: white !important;
                    border: 1px solid #e97140 !important;
                    color: #e97140 !important;
                }
                
                .bpw-keyboard-quick_reply:hover {
                    background: #e97140 !important;
                    color: white !important;
                }
                
                /* Hide bot info footer */
                .bpw-powered-by {
                    display: none !important;
                }
                
                /* Mobile responsive */
                @media (max-width: 480px) {
                    .bpw-layout {
                        width: 90vw !important;
                        height: 70vh !important;
                        max-height: 450px !important;
                        bottom: 70px !important;
                        right: 5vw !important;
                    }
                    
                    .bpw-widget-launcher {
                        bottom: 20px !important;
                        right: 20px !important;
                    }
                }
                
                /* Prevent covering header/footer */
                .bpw-layout {
                    z-index: 999 !important; /* Lower than header (9999) */
                }
                
                .bpw-widget-launcher {
                    z-index: 998 !important;
                }
                
                /* Bot avatar */
                .bpw-bot-avatar img {
                    width: 30px !important;
                    height: 30px !important;
                }
                
                /* Timestamps */
                .bpw-message-time {
                    font-size: 11px !important;
                }
                
                /* Scrollbar styling */
                .bpw-msg-list::-webkit-scrollbar {
                    width: 6px !important;
                }
                
                .bpw-msg-list::-webkit-scrollbar-track {
                    background: #f1f1f1 !important;
                }
                
                .bpw-msg-list::-webkit-scrollbar-thumb {
                    background: #e97140 !important;
                    border-radius: 3px !important;
                }
                
                .bpw-msg-list::-webkit-scrollbar-thumb:hover {
                    background: #d6612d !important;
                }
                
                /* Ensure back-to-top button is visible - moved to left side */
                #back-top, #scrollUp {
                    z-index: 1000 !important;
                    position: fixed !important;
                    bottom: 20px !important;
                    left: 20px !important;
                    right: unset !important;
                }
                
                /* Make sure back-to-top button stays on top */
                #back-top a, #scrollUp a {
                    z-index: 1001 !important;
                    position: relative !important;
                }
            `;
            document.head.appendChild(style);
        });

    </script>
    <?php
}

// Function to generate stylesheet ID
function generateStylesheetId() {
    // Generate a unique ID for custom styling
    return substr(md5('curemypet_' . date('Y-m-d')), 0, 8);
}

// Helper function to add BotPress to specific pages
function addBotPressToPage() {
    initBotPress();
}
?>