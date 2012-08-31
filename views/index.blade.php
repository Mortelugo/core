@layout('fluxbb::layout.main')

@section('main')
@foreach ($categories as $cat_info)
<?php $category = $cat_info['category']; ?>
<div id="idx{{ $category->id }}" class="blocktable"> <!-- supposed to be $cat_count -->
	<h2><span>{{ e($category->cat_name) }}</span></h2>
	<div class="box">
		<div class="inbox">
			<table cellspacing="0">
			<thead>
				<tr>
					<th class="tcl" scope="col">Category</th>
					<th class="tc2" scope="col">{{ __('fluxbb::index.topics') }}</th>
					<th class="tc3" scope="col">{{ __('fluxbb::common.posts') }}</th>
					<th class="tcr" scope="col">{{ __('fluxbb::common.last_post') }}</th>
				</tr>
			</thead>
			<tbody>
	<?php $forum_count = 0; ?>
	@foreach ($cat_info['forums'] as $forum)
<?php

		$forum_count++;
		$icon_type = 'icon';

		// TODO: Handle unread posts stuff

?>
				<tr class="row{{ HTML::oddeven() }}">
					<td class="tcl">
						<div class="{{ $icon_type }}"><div class="nosize">{{ HTML::number_format($forum_count) }}</div></div>
						<div class="tclcon">
							<div>
<?php
	if ($forum->redirect_url != '')
	{
		$forum_field = '<h3><span class="redirtext">'.__('fluxbb::common.link_to').'</span> <a href="'.e($forum->redirect_url).'" title="'.__('fluxbb::common.link_to').' '.e($forum->redirect_url).'">'.e($forum->forum_name).'</a></h3>';
	}
	else
	{
		$forum_field = '<h3><a href="'.URL::to_action('fluxbb::home@forum', array($forum->id)).'">'.e($forum->forum_name).'</a>'.(!empty($forum_field_new) ? ' '.$forum_field_new : '').'</h3>';
	}

	if ($forum->forum_desc != '')
		$forum_field .= "\n\t\t\t\t\t\t\t\t".'<div class="forumdesc">'.$forum->forum_desc.'</div>';

	if ($forum->last_post != '')
		$last_post = '<a href="'.URL::to_action('fluxbb::home@post', array($forum->last_post_id)).'#p'.$forum->last_post_id.'">'.HTML::format_time($forum->last_post).'</a> <span class="byuser">'.__('fluxbb::common.by', array('author' => e($forum->last_poster))).'</span>';
	else if (!empty($forum->redirect_url))
		$last_post = '- - -';
	else
		$last_post = __('fluxbb::common.never');

?>
								{{ $forum_field }}
							</div>
						</div>
					</td>
					<td class="tc2">{{ HTML::number_format($forum->num_topics()) }}</td>
					<td class="tc3">{{ HTML::number_format($forum->num_posts()) }}</td>
					<td class="tcr">{{ $last_post }}</td>
				</tr>
	@endforeach
			</tbody>
			</table>
		</div>
	</div>
</div>
@endforeach
@endsection
