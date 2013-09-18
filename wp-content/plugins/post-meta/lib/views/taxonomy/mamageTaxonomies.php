<?php
global $postMeta;

?>

<div class="wrap">
    <div id="pm-icon-edit-pages" class="icon32 icon32-posts-page"><br /></div>  
    <h2>Custom Taxonomy Management Panel</h2>   
    <?php do_action( 'pm_notice' ); ?>
    <div id="dashboard-widgets-wrap">
        <div class="metabox-holder">
                <div id="pm_post_taxonomy_list">
                        <?php  
                        echo $postMeta->render( 'metaBox', array( 
                                        'title'     => "Manage Taxonomies", 
                                        'content'   => $postMeta->pmTaxonomyList(), 
                                        'deleteIcon'=> false,
                                        'isOpen'    => true,
                                        'toggle'     =>  true
                                    ) );
                        if(!$postMeta->isPro()) 
                         echo $postMeta->render( 'metaBox', array( 
                                            'title'     => "Get Post Meta Pro <em>!</em>", 
                                            'content'   => $postMeta->getPostMetaPro(), 
                                            'deleteIcon'=> false,
                                            'isOpen'    => true,
                                            'toggle'     =>  true
                                        ) );
                         echo $postMeta->render( 'metaBox', array( 
                                            'title'     => "Get Start <em>!</em>", 
                                            'content'   => $postMeta->getStart(), 
                                            'deleteIcon'=> false,
                                            'isOpen'    => true,
                                            'toggle'     =>  true
                                        ) );
                        ?>
                </div>
                <div id="pm_loading_area">
                        <?php  
                         echo $postMeta->render('taxonomy','','taxonomy');
                        ?>
                </div>
        </div>
    </div>     
</div>

                    