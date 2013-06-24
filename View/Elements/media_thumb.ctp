<?php
$mediafilesDataHtml = '';
if (!empty($mediafiles[$i]['MediaLink']['id'])) {
    $mediafilesDataHtml .= $this->Html->tag(
            'input', '', array(
        'class' => 'data-MediaLink-id',
        'name' => '[MediaLink][id]',
        'value' => $mediafiles[$i]['MediaLink']['id'],
        'type' => 'hidden'
            )
    );
}

$item = $mediafiles[$i]['Mediafile'];

$mediafilesDataHtml .= $this->Html->tag(
        'input', '', array(
    'class' => 'data-Mediafile-id',
    'name' => '[Mediafile][id]',
    'value' => $item['id'],
    'type' => 'hidden'
        )
);

if ($this->Media->hasImagePreview($item['type'])) {
    $url = $this->Media->thumb(array('image' => $item['src'], 'width' => 150, 'cropratio' => '150:100'));
} else {
    $ico = 'file_default.png';

    switch ($item['type']) {

        case 'audio/wav':
        case 'audio/mp3':
            $ico = 'audio.png';
            break;

        case 'application/pdf':
            $ico = 'file_pdf.png';
            break;

        case 'application/rar':
        case 'application/x-rar-compressed':
            $ico = 'file_rar.png';
            break;

        case 'application/zip':
        case 'application/x-zip-compressed':
            $ico = 'file_zip.png';
            break;

        case 'image/bmp':
            $ico = 'image_bmp.png';
            break;

        case 'image/tiff':
            $ico = 'image_tiff.png';
            break;

        case 'audio/wmv':
        case 'audio/ogg':
        case 'video/ogv':
        case 'video/avi':
        case 'video/mpg':
        case 'video/mp4':
            $ico = 'video.png';
            break;
    }

    $url = $this->Html->url('/trois/assets/icons/' . $ico);
}
?>

<div id="<?php echo $item['id']; ?>" class="media-thumb <?php
if (( $item['type'] == 'embed/youtube' ) || ( $item['type'] == 'embed/vimeo' )) {
    echo 'video';
}
?>" >
    <div class="media-data">
        <?php echo $mediafilesDataHtml ?>
    </div>
    <div class="media-image">
        <img src="<?php echo $url; ?>" height="100" alt="" />
    </div>

    <div class="media-info">
        <div class="media-title">
            <?php echo $item['name']; ?>
        </div>
        <div class="media-details">
            <?php echo $this->Storage->format_size($item['size']) . ' - ' . $item['type']; ?>
        </div>

    </div>
    <?php if($edition) { ?>
    <div class="media-action">
        <a href="#" class="thumb-delete"  >
            Delete
        </a>
        <a href="#" class="thumb-edit"  >
            Edit
        </a>
        <input class="thumb-select" type="checkbox" />
    </div>
    <?php } ?>
</div>