<!-- BEGIN: MAIN -->
<!-- BEGIN: LIST_ROW -->

				<h3><a href="{LIST_ROW_URL}">{LIST_ROW_SHORTTITLE}</a></h3>
				<!-- IF {LIST_ROW_DESC} --><p class="small marginbottom10">{LIST_ROW_DESC}</p><!-- ENDIF -->
				<!-- IF {PHP.usr.isadmin} --><p class="small marginbottom10">{LIST_ROW_ADMIN} ({LIST_ROW_COUNT})</p><!-- ENDIF -->
				<div>
					{LIST_ROW_TEXT_CUT}
					<!-- IF {LIST_ROW_TEXT_IS_CUT} -->{LIST_ROW_MORE}<!-- ENDIF -->
				</div>
				<br />
				{LIST_ROW_COLOR_TITLE}:{LIST_ROW_COLOR}<br />
				{LIST_ROW_MASSA_TITLE}:{LIST_ROW_MASSA}<br />

				<!-- IF {LIST_ROW_PAGE_IN_GROUP_COUNT} > 1 -->
					<span style="color:red">листалка группы<br />колво в группе = {LIST_ROW_PAGE_IN_GROUP_COUNT}</span><br />
					{LIST_ROW_PAGE_GROUP_ROTATOR}
				<!-- ENDIF -->

<!-- END: LIST_ROW -->
<!-- END: MAIN -->