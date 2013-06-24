<div id="metadataFileds">
	<p><button class="btn btn-info" >Add</button></p>

	<table class="metadata-table" width="100%">
		<input type="hidden" name="data[<?php echo $datafield_model; ?>][<?php echo $datafield_field; ?>]">
		<input type="hidden" name="data[<?php echo $datafield_model; ?>][<?php echo $datafield_field; ?>][]">
		<tbody>
			<?php
			$i = 0;
			if(!empty($datafield_data))
			{
				foreach( $datafield_data as $key => $value)
				{
				?>
				<tr>
					<td class="metadata-field-key" width="30%">
						<?php
						echo $this->Form->input('key',array('value'=>$key, 'name' => 'data['.$datafield_model.']['.$datafield_field.']['.$i.'][key]' ));
						?>
					</td>
					<td class="metadata-field-value" width="60%">
						<?php
						echo $this->Form->input('value',array('value'=>$value, 'name' => 'data['.$datafield_model.']['.$datafield_field.']['.$i.'][value]' ));
						
						?>
					</td>
					<td class="metadata-field-action" width="10%">
						<button class="btn btn-danger">Delete</button>
					</td>
				</tr>
				
				<?php					
					$i++;
				}
			}
			?>
			
			<tr>
				<td class="metadata-field-key" width="30%">
					<?php
					echo $this->Form->input('key',array('value'=>'', 'name' => 'data['.$datafield_model.']['.$datafield_field.']['.$i.'][key]' ));
					?>
				</td>
				<td class="metadata-field-value" width="60%">
					<?php
					echo $this->Form->input('value',array('value'=>'', 'name' => 'data['.$datafield_model.']['.$datafield_field.']['.$i.'][value]' ));
					
					?>
				</td>
				<td class="metadata-field-action" width="10%">
					<button class="btn btn-danger">Delete</button>
				</td>
			</tr>
			
			
		</tbody>
	</table>    
</div>