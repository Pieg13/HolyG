document.addEventListener('DOMContentLoaded', () => {
    const quoteBtn = document.getElementById('randomQuoteBtn');
    const quoteDisplay = document.getElementById('quoteDisplay');

    quoteBtn.addEventListener('click', async () => {
        try {
            quoteDisplay.innerHTML = '<p class="loading basic-text">Loading quote...</p>';
            
            const response = await fetch('https://food-quote-api.vercel.app/api/foodquote');
            if (!response.ok) throw new Error('Network response was not ok');
            
            const data = await response.json();
            quoteDisplay.innerHTML = `
                <blockquote>
                    "${data.quote}"
                    <footer id="quote-footer">- ${data.author}</footer>
                </blockquote>
            `;
        } catch (error) {
            console.error('Error:', error);
            quoteDisplay.innerHTML = `<p class="error-p">Error loading quote: ${error.message}</p>`;
        }
    });
});