namespace ConferenceManager.Models
{
    using System.ComponentModel.DataAnnotations;
    using System.ComponentModel.DataAnnotations.Schema;

    public class Message
    {
        [DatabaseGenerated(DatabaseGeneratedOption.Identity)]
        public long Id { get; set; }

        [Required]
        public long SenderId { get; set; }

        public User Sender { get; set; }

        [Required]
        public long RecipientId { get; set; }

        public User Recipient { get; set; }

        [Required]
        public string Content { get; set; }
    }
}
