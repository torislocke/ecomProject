<?php include "header.php"; ?>



    <h1 className="flex justify-center pt-10 pb-12 text-2xl/7 font-bold">Menu</h1>
    <div className="flex-1 wrapper">
        <section>
            <h2 className="flex lg:justify-center font-bold pb-4">Specials</h2>
            <ul className="flex flex-col lg:items-center pb-20">
                <li>Cherry Blossom Chai</li>
                <li>Cherry Blossom Matcha</li>
                <li>Orange Blossom Cardamon Latte</li>
                <li>
                    Roses for Francine - Rose Latte with brown sugar &amp; Cinnamon
                </li>
                <li>Sweet Spring - Jasmine Tea Latte with Lavender &amp; Honey</li>
                <li>Violet Bequregard - Blueberry White Mocha</li>
            </ul>
        </section>
         <div className="flex justify-around flex-col md:flex-row flex-wrap"> 
            <div className="m-auto grid grid-cols-1 md:grid-cols-2 md:w-screen lg:grid-cols-3 max-w-[1280px] gap-10">
                <section className="basis-1/2 lg:basis-1/3">
                    <h3 className="font-bold pb-2">Coffee Drinks</h3>
                    
                    <Image
                        src='/images/coffeeCup_300pxW_223H.png'
                        alt='coffee'
                        width={50}
                        height={50} /> 

                    <ul>
                        <li>espresso</li>
                        <li>macchiato</li>
                        <li>americano</li>
                        <li>cappuccino</li>
                        <li>lattee</li>
                        <li>flavored lattee</li>
                        <li>drip</li>
                    </ul>
                </section>
                <section className="basis-1/2 lg:basis-1/3">
                    <h4 className="font-bold pb-2">Coffee Break</h4>
                    <ul>
                        <li>Hot Chocolate</li>
                        <li>Tea</li>
                        <li>Matcha</li>
                    </ul>
                </section>
                <section className="basis-1/2 lg:basis-1/3">
                    <h4 className="font-bold pb-2">Blended Drinks</h4>
                    <ul>
                        <li>Mocha Frappe</li>
                        <li>Scratch</li>
                        <li>Community Blend</li>
                    </ul>
                </section>

                <section className="basis-1/2 lg:basis-1/3">
                    <h6 className="font-bold pb-2">Pop &amp; Water</h6>
                    <ul>
                        <li>Guava Nectar</li>
                        <li>Lilikoi Passion</li>
                        <li>Passion Orange</li>
                        <li>Red Bull</li>
                        <li>Apple Juice</li>
                        <li>Limonata</li>
                        <li>Water</li>
                    </ul>
                </section>

                <section className="basis-1/2 lg:basis-1/3">
                    <h5 className="font-bold pb-2">Pastries</h5>
                    <ul>
                        <li>Apple Cornetto Turnover</li>
                        <li>Blueberry Cornmeal Muffin</li>
                        <li>Blueberry Muffin</li>
                        <li>Everything Bagel Pinwheel</li>
                        <li>Almond</li>
                        <li>Morning Roll</li>
                        <li>Morning Glory Muffin</li>
                        <li>Cherry Almond Scone</li>
                        <li>Vegan Raspberry Oat Scone</li>
                        <li>Red Mill Gluten Free Oatmill</li>
                        <li>GF Marionberry Biscuit</li>
                        <li>Homestyle Cookies</li>
                        <li>Rosemary Parmesan Bacon Biscuit</li>
                        <li></li>
                    </ul>
                </section>
                <section className="basis-1/2 lg:basis-1/3">
                    <h5 className="font-bold pb-3">Sandwiches +</h5>
                    <ul>
                        <li>Sausage Omelet Melt</li>
                        <li>Bacon, Egg &amp; Cheese</li>
                        <li>Brunch Burrito</li>
                        <li>Hard Boiled Eggs</li>
                    </ul>
                </section>
            </div>
        </div>


<?php include "footer.php"; ?>