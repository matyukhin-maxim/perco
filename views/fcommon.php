
    </div>

    <footer class="footer">
        <div class="container">
            <p class="text-muted text-center">АО "ДГК" НГРЭС. <abbr title="55-88, 51-30, 50-98">Отдел информационных технологий</abbr>. 2015г.</p>
        </div>
    </footer>

    <?php foreach ($this->scripts as $filename) {
        if (file_exists("./public/js/$filename.js"))
            printf(PHP_EOL .'<script type="text/javascript" src="%s"></script>', "/public/js/$filename.js");
    }?>


    </body>
</html>