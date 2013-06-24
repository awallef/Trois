# Require any additional compass plugins here.

# Set this to the root of your project when deployed:
http_path = "/trois/"
sass_dir = '../../src/sass'
css_dir = '../../webroot/css'
images_dir = '../../webroot/img'
javascripts_dir = '../../webroot/js'
http_stylesheets_path = 'css'
http_javascripts_path = 'js'
http_images_path = 'img'


output_style = :compressed #:nested
environment = :production #:development

# To enable relative paths to assets via compass helper functions. Uncomment:
relative_assets = true

# To disable debugging comments that display the original location of your selectors. Uncomment:
# line_comments = false
color_output = false


# If you prefer the indented syntax, you might want to regenerate this
# project again passing --syntax sass, or you can uncomment this:
# preferred_syntax = :sass
# and then run:
# sass-convert -R --from scss --to sass sass scss && rm -rf sass && mv scss sass
