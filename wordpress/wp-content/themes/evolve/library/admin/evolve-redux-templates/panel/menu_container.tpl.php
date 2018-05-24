<?php
/**
 * The template for the menu container of the panel.
 *
 * Override this template by specifying the path where it is stored (templates_path) in your Redux config.
 *
 * @author 	Redux Framework
 * @package 	ReduxFramework/Templates
 * @version:    3.5.4
 */

?>
<div class="redux-sidebar">
    <ul class="redux-group-menu">
<?php
        foreach ( $this->parent->sections as $k => $section ) {
            $suffix = "";
            $sections = array();

            $title = isset ( $section[ 'title' ] ) ? $section[ 'title' ] : '';

            $skip_sec = false;
            foreach ( $this->parent->hidden_perm_sections as $num => $section_title ) {
                if ( $section_title == $title ) {
                    $skip_sec = true;
                }
            }

            if ( isset ( $section[ 'customizer_only' ] ) && $section[ 'customizer_only' ] == true ) {
                continue;
            }

            if ( false == $skip_sec ) {
                $display = true;

                $section['class'] = isset ( $section['class'] ) ? ' ' . $section['class'] : '';

                if ( isset ( $_GET['page'] ) && $_GET['page'] == $this->parent->args['page_slug'] ) {
                    if ( isset ( $section['panel'] ) && $section['panel'] == false ) {
                        $display = false;
                    }
                }

                if ( ! $display ) {
                    return "";
                }

                if ( empty ( $sections ) ) {
                    $sections = $this->parent->sections;
                }

                $string = "";
                if ( ( ( isset ( $this->parent->args['icon_type'] ) && $this->parent->args['icon_type'] == 'image' ) || ( isset ( $section['icon_type'] ) && $section['icon_type'] == 'image' ) ) || ( isset( $section['icon'] ) && strpos( $section['icon'], '/' ) !== false ) ) {
                    //if( !empty( $this->parent->args['icon_type'] ) && $this->parent->args['icon_type'] == 'image' ) {
                    $icon = ( ! isset ( $section['icon'] ) ) ? '' : '<img class="image_icon_type" src="' . esc_url( $section['icon'] ) . '" /> ';
                } else {
                    if ( ! empty ( $section['icon_class'] ) ) {
                        $icon_class = ' ' . $section['icon_class'];
                    } elseif ( ! empty ( $this->parent->args['default_icon_class'] ) ) {
                        $icon_class = ' ' . $this->parent->args['default_icon_class'];
                    } else {
                        $icon_class = '';
                    }
                    $icon = ( ! isset ( $section['icon'] ) ) ? '<i class="el el-cog' . esc_attr( $icon_class ) . '"></i> ' : '<i class="' . esc_attr( $section['icon'] ) . esc_attr( $icon_class ) . '"></i> ';
                }
                if ( strpos( $icon, 'el-icon-' ) !== false ) {
                    $icon = str_replace( 'el-icon-', 'el el-', $icon );
                }

                $hide_section = '';
                if ( isset ( $section['hidden'] ) ) {
                    $hide_section = ( $section['hidden'] == true ) ? ' hidden ' : '';
                }

                $canBeSubSection = ( $k > 0 && ( ! isset ( $sections[ ( $k ) ]['type'] ) || $sections[ ( $k ) ]['type'] != "divide" ) ) ? true : false;

                if ( ! $canBeSubSection && isset ( $section['subsection'] ) && $section['subsection'] == true ) {
                    unset ( $section['subsection'] );
                }

                if ( isset ( $section['type'] ) && $section['type'] == "divide" ) {
                    $string .= '<li class="divide' . esc_attr( $section['class'] ) . '">&nbsp;</li>';
                } else if ( ( ! isset ( $section['subsection'] ) || $section['subsection'] != true ) && ( ! isset ( $section['childsubsection'] ) || $section['childsubsection'] != true ) ) {

                    // DOVY! REPLACE $k with $section['ID'] when used properly.
                    //$active = ( ( is_numeric($this->parent->current_tab) && $this->parent->current_tab == $k ) || ( !is_numeric($this->parent->current_tab) && $this->parent->current_tab === $k )  ) ? ' active' : '';
                    $subsections      = ( isset ( $sections[ ( $k + 1 ) ] ) && isset ( $sections[ ( $k + 1 ) ]['subsection'] ) && $sections[ ( $k + 1 ) ]['subsection'] == true ) ? true : false;
                    $subsectionsClass = $subsections ? ' hasSubSections' : '';
                    $subsectionsClass .= ( ! isset ( $section['fields'] ) || empty ( $section['fields'] ) ) ? ' empty_section' : '';
                    $extra_icon = $subsections ? '<span class="extraIconSubsections"><i class="el el-chevron-down">&nbsp;</i></span>' : '';
                    //var_dump($section);
                    $string .= '<li id="' . esc_attr( $k . $suffix ) . '_section_group_li" class="redux-group-tab-link-li' . esc_attr( $hide_section ) . esc_attr( $section['class'] ) . esc_attr( $subsectionsClass ) . '">';
                    $string .= '<a href="javascript:void(0);" id="' . esc_attr( $k . $suffix ) . '_section_group_li_a" class="redux-group-tab-link-a" data-key="' . esc_attr( $k ) . '" data-rel="' . esc_attr( $k . $suffix ) . '">' . $extra_icon . $icon . '<span class="group_title">' . wp_kses_post( $section['title'] ) . '</span></a>';

                    $nextK = $k;

                    // Make sure you can make this a subsection
                    if ( $subsections ) {
                        $string .= '<ul id="' . esc_attr( $nextK . $suffix ) . '_section_group_li_subsections" class="subsection">';
                        $doLoop = true;

                        while ( $doLoop ) {
                            $nextK += 1;
                            $display = true;

                            if ( isset ( $_GET['page'] ) && $_GET['page'] == $this->parent->args['page_slug'] ) {
                                if ( isset ( $sections[ $nextK ]['panel'] ) && $sections[ $nextK ]['panel'] == false ) {
                                    $display = false;
                                }
                            }

                            if ( count( $sections ) < $nextK || ! isset ( $sections[ $nextK ] ) || ! isset ( $sections[ $nextK ]['subsection'] ) || $sections[ $nextK ]['subsection'] != true ) {
                                $doLoop = false;
                            } else {
                                                                                                                                                                                                                                                                                                                                                                                                            if ( ! $display ) {
                                    continue;
                                }
                    
                                $hide_sub = '';
                                if ( isset ( $sections[ $nextK ]['hidden'] ) ) {
                                    $hide_sub = ( $sections[ $nextK ]['hidden'] == true ) ? ' hidden ' : '';
                                }

                                if ( ( isset ( $this->parent->args['icon_type'] ) && $this->parent->args['icon_type'] == 'image' ) || ( isset ( $sections[ $nextK ]['icon_type'] ) && $sections[ $nextK ]['icon_type'] == 'image' ) ) {
                                    //if( !empty( $this->parent->args['icon_type'] ) && $this->parent->args['icon_type'] == 'image' ) {
                                    $icon = ( ! isset ( $sections[ $nextK ]['icon'] ) ) ? '' : '<img class="image_icon_type" src="' . esc_url( $sections[ $nextK ]['icon'] ) . '" /> ';
                                } else {
                                    if ( ! empty ( $sections[ $nextK ]['icon_class'] ) ) {
                                        $icon_class = ' ' . $sections[ $nextK ]['icon_class'];
                                    } elseif ( ! empty ( $this->parent->args['default_icon_class'] ) ) {
                                        $icon_class = ' ' . $this->parent->args['default_icon_class'];
                                    } else {
                                        $icon_class = '';
                                    }
                                    $icon = ( ! isset ( $sections[ $nextK ]['icon'] ) ) ? '' : '<i class="' . esc_attr( $sections[ $nextK ]['icon'] ) . esc_attr( $icon_class ) . '"></i> ';
                                }
                                if ( strpos( $icon, 'el-icon-' ) !== false ) {
                                    $icon = str_replace( 'el-icon-', 'el el-', $icon );
                                }

                                $canBeChildSubSection = ( $nextK > 0 && ( ! isset ( $sections[ ( $nextK ) ]['type'] ) || $sections[ ( $nextK ) ]['type'] != "divide" ) ) ? true : false;

                                if ( ! $canBeSubSection && isset ( $section['childsubsection'] ) && $section['childsubsection'] == true ) {
                                    unset ( $section['childsubsection'] );
                                }

                                if ( isset ( $section['type'] ) && $section['type'] == "divide" ) {
                                    $string .= '<li class="divide' . esc_attr( $section['class'] ) . '">&nbsp;</li>';
                                } else if ( ! isset ( $section['childsubsection'] ) || $section['childsubsection'] != true ) {

                                // DOVY! REPLACE $k with $section['ID'] when used properly.
                                //$active = ( ( is_numeric($this->parent->current_tab) && $this->parent->current_tab == $k ) || ( !is_numeric($this->parent->current_tab) && $this->parent->current_tab === $k )  ) ? ' active' : '';
                                $childsubsection      = ( isset ( $sections[ ( $nextK + 1 ) ] ) && isset ( $sections[ ( $nextK + 1 ) ]['childsubsection'] ) && $sections[ ( $nextK + 1 ) ]['childsubsection'] == true ) ? true : false;
                                $childsubsectionClass = $childsubsection ? ' hasSubSections' : '';
                                $childsubsectionClass .= ( ! isset ( $section['fields'] ) || empty ( $section['fields'] ) ) ? ' empty_childsection' : '';
                                $child_extra_icon = $childsubsection ? '<span class="extraIconSubsections"><i class="el el-chevron-down">&nbsp;</i></span>' : '';
                                //var_dump($section);
                                $string .= '<li id="' . esc_attr( $nextK . $suffix ) . '_section_group_li" class="redux-group-tab-link-li' . esc_attr( $hide_section ) . esc_attr( $section['class'] ) . esc_attr( $childsubsectionClass ) . '">';
                                $string .= '<a href="javascript:void(0);" id="' . esc_attr( $nextK . $suffix ) . '_section_group_li_a" class="redux-group-tab-link-a" data-key="' . esc_attr( $nextK ) . '" data-rel="' . esc_attr( $nextK . $suffix ) . '">' . $child_extra_icon . $icon . '<span class="group_title">' . wp_kses_post( $sections[ $nextK ]['title'] ) . '</span></a>';

                                        $secondnextK = $nextK;

                                        // Make sure you can make this a childsubsection
                                        if ( $childsubsection ) {
                                            $string .= '<ul id="' . esc_attr( $nextK . $suffix ) . '_section_group_li_childsubsections" class="childsubsection">';
                                            $child_doLoop = true;

                                            while ( $child_doLoop ) {
                                                $secondnextK += 1;
                                                $child_display = true;

                                                if ( isset ( $_GET['page'] ) && $_GET['page'] == $this->parent->args['page_slug'] ) {
                                                    if ( isset ( $sections[ $secondnextK ]['panel'] ) && $sections[ $secondnextK ]['panel'] == false ) {
                                                        $child_display = false;
                                                    }
                                                }

                                                if ( count( $sections ) < $secondnextK || ! isset ( $sections[ $secondnextK ] ) || ! isset ( $sections[ $secondnextK ]['childsubsection'] ) || $sections[ $secondnextK ]['childsubsection'] != true ) {
                                                    $child_doLoop = false;
                                                    $nextK = $secondnextK - 1;
                                                } else {
                                                    if ( ! $child_display ) {
                                                        continue;
                                                    }

                                                    $hide_subchild = '';
                                                    if ( isset ( $sections[ $secondnextK ]['hidden'] ) ) {
                                                        $hide_subchild = ( $sections[ $secondnextK ]['hidden'] == true ) ? ' hidden ' : '';
                                                    }

                                                    if ( ( isset ( $this->parent->args['icon_type'] ) && $this->parent->args['icon_type'] == 'image' ) || ( isset ( $sections[ $secondnextK ]['icon_type'] ) && $sections[ $secondnextK ]['icon_type'] == 'image' ) ) {
                                                        //if( !empty( $this->parent->args['icon_type'] ) && $this->parent->args['icon_type'] == 'image' ) {
                                                        $child_icon = ( ! isset ( $sections[ $secondnextK ]['icon'] ) ) ? '' : '<img class="image_icon_type" src="' . esc_url( $sections[ $secondnextK ]['icon'] ) . '" /> ';
                                                    } else {
                                                        if ( ! empty ( $sections[ $secondnextK ]['icon_class'] ) ) {
                                                            $child_icon_class = ' ' . $sections[ $secondnextK ]['icon_class'];
                                                        } elseif ( ! empty ( $this->parent->args['default_icon_class'] ) ) {
                                                            $child_icon_class = ' ' . $this->parent->args['default_icon_class'];
                                                        } else {
                                                            $child_icon_class = '';
                                                        }
                                                        $child_icon = ( ! isset ( $sections[ $secondnextK ]['icon'] ) ) ? '' : '<i class="' . esc_attr( $sections[ $secondnextK ]['icon'] ) . esc_attr( $child_icon_class ) . '"></i> ';
                                                    }
                                                    if ( strpos( $child_icon, 'el-icon-' ) !== false ) {
                                                        $child_icon = str_replace( 'el-icon-', 'el el-', $child_icon );
                                                    }

                                                    $sections[ $secondnextK ]['class'] = isset($sections[ $secondnextK ]['class']) ? $sections[ $secondnextK ]['class'] : '';
                                                    $section[ $secondnextK ]['class'] = isset ( $section[ $secondnextK ]['class'] ) ? $section[ $secondnextK ]['class'] : $sections[ $secondnextK ]['class'];
                                                    $string .= '<li id="' . esc_attr( $secondnextK . $suffix ) . '_section_group_li" class="redux-group-tab-link-li ' . esc_attr( $hide_subchild ) . esc_attr( $section[ $secondnextK ]['class'] ) . ( $child_icon ? ' hasIcon' : '' ) . '">';
                                                    $string .= '<a href="javascript:void(0);" id="' . esc_attr( $secondnextK . $suffix ) . '_section_group_li_a" class="redux-group-tab-link-a" data-key="' . esc_attr( $secondnextK ) . '" data-rel="' . esc_attr( $secondnextK . $suffix ) . '">' . $child_icon . '<span class="group_title">' . wp_kses_post( $sections[ $secondnextK ]['title'] ) . '</span></a>';
                                                    $string .= '</li>';
                                                }
                                            }

                                            $string .= '</ul>';
                                        }
                                }
                             
                                $string .= '</li>';
                            }
                        }

                        $string .= '</ul>';
                    }

                    $string .= '</li>';
                }

                echo $string;
      
                $skip_sec = false;
            }
        }

        /**
         * action 'redux-page-after-sections-menu-{opt_name}'
         *
         * @param object $this ReduxFramework
         */
        do_action ( "redux-page-after-sections-menu-{$this->parent->args[ 'opt_name' ]}", $this );

        /**
         * action 'redux/page/{opt_name}/menu/after'
         *
         * @param object $this ReduxFramework
         */
        do_action ( "redux/page/{$this->parent->args[ 'opt_name' ]}/menu/after", $this );
?>
    </ul>
</div>